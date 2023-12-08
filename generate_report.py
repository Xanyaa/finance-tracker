from flask import Flask, request, jsonify
import mysql.connector
from reportlab.pdfgen import canvas
from datetime import datetime, timedelta
import smtplib
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart
from email.mime.application import MIMEApplication
from reportlab.lib import colors
from reportlab.lib.pagesizes import letter
from reportlab.platypus import Table, TableStyle


app = Flask(__name__)

def connect_to_database():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",
        database="project_s"
    )

def generate_monthly_report(start_date, end_date, user_email):
    start_date = datetime.strptime(start_date, "%Y-%m-%d")
    end_date = datetime.strptime(end_date, "%Y-%m-%d") + timedelta(days=1)

    try:
        db_connection = connect_to_database()
        cursor = db_connection.cursor(dictionary=True)

        query = """
            SELECT 
                'Income' AS type,
                income.Description AS description,
                income.Amount AS amount,
                income.Received_dt AS transaction_date
            FROM income
            JOIN users ON income.User_id = users.Id
            WHERE income.Received_dt BETWEEN %s AND %s AND users.Email = %s

            UNION ALL

            SELECT 
                'Expense' AS type,
                expense.Description AS description,
                expense.Amount AS amount,
                expense.Received_dt AS transaction_date
            FROM expense
            JOIN users ON expense.User_id = users.Id
            WHERE expense.Received_dt BETWEEN %s AND %s AND users.Email = %s
        """

        # Execute the query with the updated parameters
        cursor.execute(query, (start_date, end_date, user_email, start_date, end_date, user_email))
        result = cursor.fetchall()

        pdf_filename = "monthly_report.pdf"
        c = canvas.Canvas(pdf_filename, pagesize=letter)
        width, height = letter

        # Header information
        header_text = "Transactions Report"
        period_text = f"Period: {start_date.strftime('%Y-%m-%d')} to {end_date.strftime('%Y-%m-%d')}"
        divider_text = "----------------------"

        c.setFont("Helvetica", 12)

        # Set the initial y-coordinate for drawing
        y_coordinate = height - 100

        # Draw the header information
        c.drawString(100, y_coordinate, header_text)
        y_coordinate -= 15
        c.drawString(100, y_coordinate, period_text)
        y_coordinate -= 15
        c.drawString(100, y_coordinate, divider_text)
        y_coordinate -= 15

        data = [["Type", "Description", "Amount", "Transaction Date"]]
        for row in result:
            data.append([row['type'], row['description'], row['amount'], row['transaction_date'].strftime('%Y-%m-%d')])

        # Set the table style
        style = TableStyle([
            ('BACKGROUND', (0, 0), (-1, 0), colors.grey),
            ('TEXTCOLOR', (0, 0), (-1, 0), colors.whitesmoke),
            ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
            ('FONTNAME', (0, 0), (-1, 0), 'Helvetica-Bold'),
            ('BOTTOMPADDING', (0, 0), (-1, 0), 12),
            ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
            ('GRID', (0, 0), (-1, -1), 1, colors.black),
        ])

        # Create the table and apply the style
        table = Table(data)
        table.setStyle(style)

        # Calculate the table height
        table_height = table.wrapOn(c, width, height)[1]

        # Check if the table fits on the page
        if y_coordinate - table_height > 50:
            # Draw the table on the canvas
            table.drawOn(c, 100, y_coordinate - table_height)
        else:
            # Handle overflow by adding a new page and drawing the table on the new page
            c.showPage()
            y_coordinate = height - 100
            c.drawString(100, y_coordinate, header_text)
            y_coordinate -= 15
            c.drawString(100, y_coordinate, period_text)
            y_coordinate -= 15
            c.drawString(100, y_coordinate, divider_text)
            y_coordinate -= 15
            table.drawOn(c, 100, y_coordinate - table_height)

        c.save()

        send_email(pdf_filename, user_email)

        cursor.close()
        db_connection.close()

        return "Report generated and emailed successfully!"

    except Exception as e:
        return f"Error: {e}"

def send_email(pdf_filename, recipient_email):
    smtp_server = "smtp.gmail.com"
    smtp_port = 587
    smtp_username = "k213402@nu.edu.pk"
    smtp_password = "5656stArpott"
    sender_email = "k213402@nu.edu.pk"

    msg = MIMEMultipart()
    msg['From'] = sender_email
    msg['To'] = recipient_email
    msg['Subject'] = "Monthly Report"

    with open(pdf_filename, "rb") as attachment:
        part = MIMEApplication(attachment.read(), Name=pdf_filename)
        part['Content-Disposition'] = f'attachment; filename="{pdf_filename}"'
        msg.attach(part)

    with smtplib.SMTP(smtp_server, smtp_port) as server:
        server.starttls()
        server.login(smtp_username, smtp_password)
        server.sendmail(sender_email, recipient_email, msg.as_string())

@app.route('/generate_report', methods=['POST'])
def generate_report():
    if request.method == 'POST':
        try:
            start_date = request.form['start_date']
            end_date = request.form['end_date']
            user_email = request.form['user_email']

            result = generate_monthly_report(start_date, end_date, user_email)
            return jsonify({"result": result})

        except Exception as e:
            print(f"Error: {e}")
            return jsonify({"error": "Internal Server Error"}), 500

    return jsonify({"error": "Invalid Request"})

if __name__ == "__main__":
    app.run(port=5000)