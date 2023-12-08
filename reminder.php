<?php
include "dblocal.php";

session_start();

// Check if the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] != 1) {
    header("Location: http://localhost/ElaAdmin-master/index.php");
    exit;
}

// Retrieve user information from the session
if (isset($_SESSION['Id'], $_SESSION['Username'])) {
    $userId = $_SESSION['Id'];
    $username = $_SESSION['Username'];
} else {
    echo "Invalid user information";
    header("Location: http://localhost/ElaAdmin-master/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Finance Tracker</title>
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <div id="main-wrapper">
    <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <!-- <b><img src="images\logo.png" alt="homepage" class="dark-logo" /></b> -->
                        <!-- End Logo icon -->
                        <!-- Logo text -->
                        <span><img src="images/FT-logo-text.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse justify-content-end"> <!-- Use justify-content-end to move items to the right -->
                    <!-- User profile and search -->
                    <ul class="navbar-nav">
                        <!-- Move the user profile to the right end -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="images/users/17.png" alt="user" class="profile-pic" />
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="javascript:;" data-toggle="modal" data-target="#changePassModal"><i class="ti-user"></i> Change Password</a></li>
                                    <li><a href="chart_balance.php"><i class="ti-wallet"></i> Balance</a></li>
                                    <!-- <li><a href="#"><i class="ti-email"></i> Inbox</a></li> -->
                                    <!-- <li role="separator" class="divider"></li> -->
                                    <li><a href="app-profile.php"><i class="ti-settings"></i> Setting</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->

        <!-- --------------------------------------LEFT SIDEBAR----------------------------------- -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Menu</li>

                        <li> <a href="main.php" aria-expanded="false"><i class="fa fa-home"></i><span class="hide-menu">Home</span></a>
                        </li>
                        <li> <a href="app-profile.php" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Profile</span></a>
                        </li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Transactions</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="table-income.php">Income</a></li>
                                <li><a href="table-expense.php">Expense</a></li>
                                <li><a href="gen-report.php">Generate Reports</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Charts</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="chart_balance.php">Balance</a></li>
                                <li><a href="chart_income.php">Income</a></li>
                                <li><a href="chart_expense.php">Expense</a></li>
                            </ul>
                        </li>

                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Components <span class="label label-rouded label-danger pull-right">4</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="budget.php">Budget</a></li>
                                <li><a href="reminder.php">Reminder</a></li>
                                <li><a href="categories.php">Categories</a></li>
                                <li><a href="goals.php">Goals</a></li>
                            </ul>
                        </li>

                        <li> <a href="about_us.php" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">About Us</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- -----------------------------END LEFT SIDEBAR---------------------------------------  -->

        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- -------------------------START BREAD CRUMB-------------------------------------- -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Components</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Reminder</a></li>
                        <li class="breadcrumb-item active"><?php echo $_SESSION['Username']; ?></li>
                    </ol>
                </div>
            </div>
            <!-- --------------------------END BREAD CRUMB--------------------------------------- -->

            <!-- Container fluid -->
            <div class="container-fluid">
                <!-- Page content goes here -->
<style>
    /* Customize the dropdown buttons */
    .income-action-btn {
        background-color: #3498db; /* Blue color for buttons */
        color: #fff; /* White text color */
        border: 1px solid #3498db; /* Blue border */
        margin-right: 5px; /* Add some margin between buttons */
    }

    .income-action-btn:hover {
        background-color: #3498db; /* Darker blue color on hover */
        border: 1px solid #2980b9; /* Darker blue border on hover */
    }

    /* Customize the dropdown menu */
    .dropdown-menu {
        background-color: #f8f9fa; /* Light gray background color */
        border: 1px solid #ced4da; /* Light gray border */
    }

    .dropdown-menu a {
        color: #3498db; /* Dark gray text color */
    }

    .dropdown-menu a:hover {
        background-color: #3498db; /* Lighter gray background on hover */
        color: #fff;
    }
</style>
            <!-- Fetch reminder data for the logged-in user based on user's ID -->
            <?php
            $reminderQuery = "
                SELECT r.Id, r.Description, r.Date, r.Created_dt, r.Updated_dt
                FROM reminder r
                WHERE r.User_id = ?
            ";

            $reminderStmt = $conn->prepare($reminderQuery);

            if (!$reminderStmt) {
                echo "Error in preparing reminder query: " . $conn->error;
                exit;
            }

            $reminderStmt->bind_param("i", $userId);
            $reminderStmt->execute();

            // Check for errors
            if ($reminderStmt->error) {
                echo "Error in executing reminder query: " . $reminderStmt->error;
                exit;
            }

            $reminderResult = $reminderStmt->get_result();

            // Close the prepared statement
            $reminderStmt->close();
            ?>

            <!-- Display the reminder table with dynamic data -->
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Reminder Table</h2>
                    <h6 class="card-subtitle">Data table example</h6>
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Reminder ID</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Created Date</th>
                                    <th>Updated Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Loop through the fetched reminder data and display it in the table
                                while ($row = $reminderResult->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['Id'] . "</td>";
                                    echo "<td>" . $row['Description'] . "</td>";
                                    echo "<td>" . $row['Date'] . "</td>";
                                    echo "<td>" . $row['Created_dt'] . "</td>";
                                    echo "<td>" . $row['Updated_dt'] . "</td>";

                                    // Add action buttons
                                    echo "<td class='dropdown'>";
                                    echo "<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions</button>";
                                    echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
                                    echo "<a class='dropdown-item' href='#' onclick='deleteReminder(" . $row['Id'] . ")'>Delete</a>";
                                    echo "<a class='dropdown-item' href='#' onclick='updateReminder(" . $row['Id'] . ", \"" . $row['Description'] . "\", \"" . $row['Date'] . "\")' data-bs-toggle='modal' data-bs-target='#updateReminderModal'>Edit</a>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Insert new Reminder -->
            <div class="card mt-4" id="insertReminderForm">
                <div class="card-body">
                    <h2 class="card-title">Insert New Reminder</h2>
                    <form id="insertReminderForm">
                        <div class="form-group">
                            <label for="reminderDescription">Description:</label>
                            <input type="text" class="form-control" id="reminderDescription" name="reminderDescription" required>
                        </div>
                        <div class="form-group">
                            <label for="reminderDate">Date:</label>
                            <input type="date" class="form-control" id="reminderDate" name="reminderDate" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="insertReminder()">Insert Reminder</button>
                    </form>
                </div>
            </div>

            <!-- Update Reminder Modal -->
            <div class="modal fade" id="updateReminderModal" tabindex="-1" aria-labelledby="updateReminderModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateReminderModalLabel">Update Reminder</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateReminderForm">
                                <input type="hidden" id="updateReminderId" name="updateReminderId">
                                <div class="mb-3">
                                    <label for="updateReminderDescription" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="updateReminderDescription" name="updateReminderDescription" required>
                                </div>
                                <div class="mb-3">
                                    <label for="updateReminderDate" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="updateReminderDate" name="updateReminderDate" required>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="updateReminderSubmit()">Save changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Container fluid -->

         <!-- footer -->
         <footer class="footer"> © BSCS-5B All rights reserved. Template designed by <a href="about_us.php">usman-owais-sania</a></footer>
        <!-- End footer -->
    </div>
    <!-- End Page wrapper -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script>
        // Initialize DataTables
        $(document).ready(function () {
            $('#myTable').DataTable();
        });
    </script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script>
        // Function to delete a reminder
        function deleteReminder(reminderId) {
            if (confirm('Are you sure you want to delete this reminder?')) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_reminder.php',
                    data: {
                        reminderId: reminderId
                    },
                    success: function (response) {
                        // Reload the page after successful deletion
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Error deleting reminder. Please try again.');
                    }
                });
            }
        }

        function updateReminder(reminderId, description, date) {
            $('#updateReminderId').val(reminderId);
            $('#updateReminderDescription').val(description);
            $('#updateReminderDate').val(date);

            // Trigger the modal manually
            $('#updateReminderModal').modal('show');
        }

        // Function to submit updated reminder data
        function updateReminderSubmit() {
            var reminderId = $('#updateReminderId').val();
            var description = $('#updateReminderDescription').val();
            var date = $('#updateReminderDate').val();

            // Perform validation here if needed

            $.ajax({
                type: 'POST',
                url: 'update_reminder.php',
                data: {
                    reminderId: reminderId,
                    description: description,
                    date: date
                },
                success: function (response) {
                    // Reload the page after successful update
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Error updating reminder. Please try again.');
                }
            });
        }

        // Function to insert a new reminder
        function insertReminder() {
            var description = $('#reminderDescription').val();
            var date = $('#reminderDate').val();

            // Perform validation here if needed

            $.ajax({
                type: 'POST',
                url: 'insert_reminder.php',
                data: {
                    description: description,
                    date: date
                },
                success: function (response) {
                    // Reload the page after successful insertion
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Error inserting reminder. Please try again.');
                }
            });
        }
    </script>
</body>

</html>
