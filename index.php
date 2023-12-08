<?php
include "dblocal.php";

// Check if the login form has been submitted
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['login'])) {
    // Retrieve user input
    $myemail = $_POST['Email'];
    $mypassword = $_POST['Password'];

    // Use prepared statements to prevent SQL injection
    $sql = "SELECT Id, Username, Email, Password FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $myemail);
    $stmt->execute();
    $stmt->bind_result($userId, $Username, $userEmail, $stored_hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the entered password against the stored hashed password
    if (password_verify($mypassword, $stored_hashed_password)) {
        // Successfully verified login information
        session_start();

        if (!isset($_SESSION['is_logged_in'])) {
            $_SESSION['is_logged_in'] = 1;
        }

        // Store user ID and Username in the session
        $_SESSION['Id'] = $userId;
        $_SESSION['Username'] = $Username;
        $_SESSION['Email'] = $userEmail;

        // Redirect to the main.php page
        header("Location: main.php");
        exit;
    } else {
        // Incorrect password. Redirect back to the login page with an error message
        header("Location: index.php?err=INCORRECT USER LOGIN");
        exit;
    }
}
?>

<!-- The rest of your HTML code remains unchanged -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Finance Tracker</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">

        <div class="unix-login">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="login-content card">
                            <div class="login-form">
                                <h4>Login</h4>
                                <form method="POST" action="index.php">
                                    <div class="form-group">
                                        <label>Email address</label>
                                        <input type="email" class="form-control" name="Email" placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input type="password" class="form-control" name="Password" placeholder="Password">
                                    </div>
                                    <button type="submit" name="login" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                                    <div class="register-link m-t-15 text-center">
                                        <p>Don't have account ? <a href="page-register.php">Sign Up Here</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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

</body>

</html>