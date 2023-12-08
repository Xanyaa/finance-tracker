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
        <!-- -------------------------------------HEADER HEADER---------------------------------------  -->
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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Goals</a></li>
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

                <?php
                // Fetch goal data for the logged-in user based on user's ID
                $goalQuery = "
                    SELECT g.Id, g.Name, g.Target_amount, g.Target_dt, g.Current_amount, g.Created_dt, g.Updated_dt, g.Status
                    FROM goals g
                    WHERE g.User_id = ?
                ";

                $goalStmt = $conn->prepare($goalQuery);

                if (!$goalStmt) {
                    echo "Error in preparing goal query: " . $conn->error;
                    exit;
                }

                $goalStmt->bind_param("i", $userId);
                $goalStmt->execute();

                // Check for errors
                if ($goalStmt->error) {
                    echo "Error in executing goal query: " . $goalStmt->error;
                    exit;
                }

                $goalResult = $goalStmt->get_result();

                // Close the prepared statement
                $goalStmt->close();
                ?>

                <!-- Display the goal table with dynamic data -->
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Goal Table</h2>
                        <h6 class="card-subtitle">Data table example</h6>
                        <div class="table-responsive m-t-40">
                            <table id="myTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Goal ID</th>
                                        <th>Name</th>
                                        <th>Target Amount</th>
                                        <th>Target Date</th>
                                        <th>Current Amount</th>
                                        <th>Created Date</th>
                                        <th>Updated Date</th>
                                        <th>Status</th>
                                        <th>Actions</th> <!-- New column for actions -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through the fetched goal data and display it in the table
                                    while ($row = $goalResult->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row['Id'] . "</td>";
                                        echo "<td>" . $row['Name'] . "</td>";
                                        echo "<td>" . $row['Target_amount'] . "</td>";
                                        echo "<td>" . $row['Target_dt'] . "</td>";
                                        echo "<td>" . $row['Current_amount'] . "</td>";
                                        echo "<td>" . $row['Created_dt'] . "</td>";
                                        echo "<td>" . $row['Updated_dt'] . "</td>";
                                        echo "<td>" . $row['Status'] . "</td>";

                                        // Add action buttons
                                        echo "<td class='dropdown'>";
                                        echo "<button class='btn btn-secondary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Actions</button>";
                                        echo "<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
                                        echo "<a class='dropdown-item' href='#' onclick='deleteGoal(" . $row['Id'] . ")'>Delete</a>";
                                        echo "<a class='dropdown-item' href='#' onclick='updateGoal(" . $row['Id'] . ", \"" . $row['Name'] . "\", " . $row['Target_amount'] . ", \"" . $row['Target_dt'] . "\", \"" . $row['Status'] . "\", " . $row['Current_amount'] . ")' data-bs-toggle='modal' data-bs-target='#updateGoalModal'>Edit</a>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Insert new Goal -->
                <div class="card mt-4" id="insertGoalForm">
                    <div class="card-body">
                        <h2 class="card-title">Insert New Goal</h2>
                        <form id="insertGoalForm">
                            <div class="form-group">
                                <label for="goalName">Goal Name:</label>
                                <input type="text" class="form-control" id="goalName" name="goalName" required>
                            </div>
                            <div class="form-group">
                                <label for="targetAmount">Target Amount:</label>
                                <input type="number" class="form-control" id="targetAmount" name="targetAmount" required>
                            </div>
                            <div class="form-group">
                                <label for="targetDate">Target Date:</label>
                                <input type="date" class="form-control" id="targetDate" name="targetDate" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="Done">Done</option>
                                    <option value="Not Done">Not Done</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="currentAmount">Current Amount:</label>
                                <input type="number" class="form-control" id="currentAmount" name="currentAmount" required>
                            </div>
                            <button type="button" class="btn btn-primary" onclick="insertGoal()">Insert Goal</button>
                        </form>
                    </div>
                </div>

                <!-- Update Goal Modal -->
                <div class="modal fade" id="updateGoalModal" tabindex="-1" aria-labelledby="updateGoalModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="updateGoalModalLabel">Update Goal</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateGoalForm">
                                    <input type="hidden" id="updateGoalId" name="updateGoalId">
                                    <div class="mb-3">
                                        <label for="updateGoalName" class="form-label">Goal Name</label>
                                        <input type="text" class="form-control" id="updateGoalName" name="updateGoalName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateTargetAmount" class="form-label">Target Amount</label>
                                        <input type="number" class="form-control" id="updateTargetAmount" name="updateTargetAmount" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateTargetDate" class="form-label">Target Date</label>
                                        <input type="date" class="form-control" id="updateTargetDate" name="updateTargetDate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateStatus" class="form-label">Status</label>
                                        <select class="form-select" id="updateStatus" name="updateStatus" required>
                                            <option value="Done">Done</option>
                                            <option value="Not Done">Not Done</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="updateCurrentAmount" class="form-label">Current Amount</label>
                                        <input type="number" class="form-control" id="updateCurrentAmount" name="updateCurrentAmount" required>
                                    </div>
                                    <button type="button" class="btn btn-primary" onclick="updateGoalSubmit()">Save changes</button>
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
        // Function to delete a goal
        function deleteGoal(goalId) {
            if (confirm('Are you sure you want to delete this goal?')) {
                $.ajax({
                    type: 'POST',
                    url: 'delete_goal.php',
                    data: {
                        goalId: goalId
                    },
                    success: function (response) {
                        // Reload the page after successful deletion
                        location.reload();
                    },
                    error: function (error) {
                        console.log(error);
                        alert('Error deleting goal. Please try again.');
                    }
                });
            }
        }

        function updateGoal(goalId, goalName, targetAmount, targetDate, status, currentAmount) {
        $('#updateGoalId').val(goalId);
        $('#updateGoalName').val(goalName);
        $('#updateTargetAmount').val(targetAmount);
        $('#updateTargetDate').val(targetDate);
        $('#updateStatus').val(status);
        $('#updateCurrentAmount').val(currentAmount);

        // Trigger the modal manually
        $('#updateGoalModal').modal('show');
    }

        // Function to submit updated goal data
        function updateGoalSubmit() {
            var goalId = $('#updateGoalId').val();
            var goalName = $('#updateGoalName').val();
            var targetAmount = $('#updateTargetAmount').val();
            var targetDate = $('#updateTargetDate').val();
            var status = $('#updateStatus').val(); // Assuming you have an input field with id 'updateStatus'
            var currentAmount = $('#updateCurrentAmount').val(); // Assuming you have an input field with id 'updateCurrentAmount'

            // Perform validation here if needed

            $.ajax({
                type: 'POST',
                url: 'update_goal.php',
                data: {
                    goalId: goalId,
                    goalName: goalName,
                    targetAmount: targetAmount,
                    targetDate: targetDate,
                    status: status,
                    currentAmount: currentAmount
                },
                success: function (response) {
                    // Reload the page after successful update
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Error updating goal. Please try again.');
                }
            });
        }

        // Function to insert a new goal
        function insertGoal() {
            var goalName = $('#goalName').val();
            var targetAmount = $('#targetAmount').val();
            var targetDate = $('#targetDate').val();
            var status = 'Done'; // Set a default status
            var currentAmount = 0; // Set a default current amount

            // Perform validation here if needed

            $.ajax({
                type: 'POST',
                url: 'insert_goal.php',
                data: {
                    goalName: goalName,
                    targetAmount: targetAmount,
                    targetDate: targetDate,
                    status: status,
                    currentAmount: currentAmount
                },
                success: function (response) {
                    // Reload the page after successful insertion
                    location.reload();
                },
                error: function (error) {
                    console.log(error);
                    alert('Error inserting goal. Please try again.');
                }
            });
        }
    </script>
</body>

</html>
