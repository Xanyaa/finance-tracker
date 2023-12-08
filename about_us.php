<?php
include "dblocal.php";

session_start();

// Retrieve user information from the session
if (isset($_SESSION['Id'], $_SESSION['Username'])) {
    $userId = $_SESSION['Id'];
    $username = $_SESSION['Username'];

    // Fetch 'Email' for the logged-in user
    $emailQuery = "SELECT email FROM users WHERE Id = ?";
    $emailStmt = $conn->prepare($emailQuery);
    $emailStmt->bind_param("i", $userId); // Assuming Id is an integer
    $emailStmt->execute();
    $emailStmt->bind_result($email);
    $emailStmt->fetch();
    $emailStmt->close();
} else {
    echo "Invalid user information";
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
    // Get the new username from the form
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];


    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $truncatedPassword = substr($hashedPassword, 0, 19);

    // Update the username in the database
    $updateUsernameQuery = "UPDATE users SET username = '$newUsername' WHERE id = $userId";
    mysqli_query($conn, $updateUsernameQuery);

    // Update the email in the database
    $updateEmailQuery = "UPDATE users SET Email = '$newEmail' WHERE id = $userId";
    mysqli_query($conn, $updateEmailQuery);

    $updatePasswordQuery = "UPDATE users SET Password = '$truncatedPassword' WHERE id = $userId";
    mysqli_query($conn, $updatePasswordQuery);

    // Update the email in the session
    $_SESSION['Username'] = $newUsername;
    $_SESSION['Email'] = $newEmail;
    $_SESSION['Password'] = $newPassword;

    // Redirect back to the profile page
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>About Us</title>
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
                    <h3 class="text-primary">About-Us</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">About-Us</a></li>
                        <li class="breadcrumb-item active"><?php echo $_SESSION['Username']; ?></li>
                    </ol>
                </div>
            </div>
            <!-- --------------------------END BREAD CRUMB--------------------------------------- -->
            
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-two">
                                    <header>
                                        <div class="avatar">
                                            <img src="images\developers-pics\owais_siddiqi_dp.jpeg" alt="OwaisPicture" />
                                        </div>
                                    </header>

                                    <h3>Owais Siddiqi</h3>

                                    <div class="bio" style="text-align: center;">
                                    "I say to you today, my friends, so even though we face the difficulties of today and tomorrow, I still have a dream. It is a dream deeply rooted in the American dream. I have a dream that one day this nation will rise up and live out the true meaning of its creed: 'We hold these truths to be self-evident, that all men are created equal.'"
                                    </div>
                                    <div class="contacts" style="margin-top: 20px;">
                                        <a href="https://www.instagram.com/owais_siddiqi/"><i class="fa fa-instagram"></i></a>
                                        <a href="https://www.linkedin.com/in/owais-siddiqi-a07547173/"><i class="fa fa-linkedin"></i></a>
                                        <a href="mailto:hasanowais786@gmail.com"><i class="fa fa-envelope"></i></a>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-two">
                                    <header>
                                        <div class="avatar">
                                            <img src="images\developers-pics\sania_dp.png" alt="SaniaPicture" />
                                        </div>
                                    </header>

                                    <h3>Sania Hasan</h3>

                                    <div class="bio" style="text-align: center;">
                                    "Let us not seek to satisfy our thirst for freedom by drinking from the cup of bitterness and hatred. We must forever conduct our struggle on the high plane of dignity and discipline. We must not allow our creative protest to degenerate into physical violence. Again and again, we must rise to the majestic heights of meeting physical force with soul force."
                                    </div>
                                    <div class="contacts" style="margin-top: 20px;">
                                        <a href="https://www.instagram.com/_.xanya._/"><i class="fa fa-instagram"></i></a>
                                        <a href="https://www.linkedin.com/in/syeda-sania-hasan-980220192/"><i class="fa fa-linkedin"></i></a>
                                        <a href="mailto:k214671@nu.edu.pk"><i class="fa fa-envelope"></i></a>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-two">
                                    <header>
                                        <div class="avatar">
                                            <img src="images\developers-pics\usman_dp.jpeg" alt="UsmanPicture" />
                                        </div>
                                    </header>

                                    <h3>Usman Arif</h3>

                                    <div class="bio" style="text-align: center;">
                                    "There is no greater agony than bearing an untold story inside you. You may not control all the events that happen to you, but you can decide not to be reduced by them. Try to be a rainbow in someone's cloud. You may not make it through the storm, but if you do, someone will find you and know you were there."
                                    </div>
                                    <div class="contacts" style="margin-top: 20px;">
                                        <a href="https://www.instagram.com/usmanarif13/"><i class="fa fa-instagram"></i></a>
                                        <a href="https://www.linkedin.com/in/usman-arif-0b394a256/"><i class="fa fa-linkedin"></i></a>
                                        <a href="mailto:k213448@nu.edu.pk"><i class="fa fa-envelope"></i></a>
                                        <div class="clear"></div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                </div>
                <!-- Column -->
            </div>

            <!-- End PAge Content -->
        </div>
        <!-- End Container fluid  -->

        <!-- footer -->
        <footer class="footer"> © BSCS-5B All rights reserved. Template designed by <a href="about_us.php">usman-owais-sania</a></footer>
        <!-- End footer -->
    </div>
    <!-- End Page wrapper  -->
    </div>

    <div class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="changePassModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:;" novalidate="novalidate">
                    <div class="modal-header">
                        <h5 class="modal-title">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group">
                                <label for="oldPass">
                                    old Password
                                </label>
                                <input type="password" data-val="true" data-val-required="this is Required Field" class="form-control" name="oldPass" id="oldPass" />
                                <span class="field-validation-valid text-danger" data-valmsg-for="oldPass" data-valmsg-replace="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="newPass">
                                    New Password
                                </label>
                                <input type="password" data-val="true" data-val-required="this is Required Field" class="form-control" name="newPass" id="newPass" />
                                <span class="field-validation-valid text-danger" data-valmsg-for="newPass" data-valmsg-replace="true"></span>

                            </div>
                            <div class="form-group">
                                <label for="confirmPass">
                                    Confirm Password
                                </label>
                                <input type="password" data-val-equalto="Password not Match " , data-val-equalto-other="newPass" data-val="true" data-val-required="this is Required Field" class="form-control" name="confirmPass" id="confirmPass" />
                                <span class="field-validation-valid text-danger" data-valmsg-for="confirmPass" data-valmsg-replace="true"></span>

                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate.min.js"></script>
    <script src="js/lib/form-validation/jquery.validate.unobtrusive.min.js"></script>
    <script src="js/lib/jquery.nicescroll/jquery.nicescroll.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <script>
        $(function() {
            $("html").niceScroll({
                cursorcolor: "#16385d",
                cursorwidth: "5px",
                background: "#fff",
                cursorborder: "1px solid #5c4ac7",
                cursorborderradius: 0
            }); // a world f
        });
    </script>
</body>

</html>