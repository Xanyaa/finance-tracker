<?php
include "dblocal.php";
session_start();
// Check if the user is logged in
if (!isset($_SESSION['is_logged_in']) || $_SESSION['is_logged_in'] != 1) {
    header("Location: index.php");
    exit;
}

// Retrieve user information from the session
if (isset($_SESSION['Id'], $_SESSION['Username'])) {
    $userId = $_SESSION['Id'];
    $username = $_SESSION['Username'];

    // Fetch 'Balance' for the logged-in user
    $balanceQuery = "SELECT Balance FROM users WHERE Id = ?";
    $balanceStmt = $conn->prepare($balanceQuery);
    $balanceStmt->bind_param("i", $userId); // Assuming Id is an integer
    $balanceStmt->execute();
    $balanceStmt->bind_result($balance);
    $balanceStmt->fetch();
    $balanceStmt->close();

    // Calculate the sum of income for the last 30 days
    $incomeQuery = "SELECT SUM(Amount) FROM income WHERE User_id = ? AND Received_dt >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $incomeStmt = $conn->prepare($incomeQuery);
    $incomeStmt->bind_param("i", $userId); // Assuming Id is an integer
    $incomeStmt->execute();
    $incomeStmt->bind_result($income_sum);
    $incomeStmt->fetch();
    $incomeStmt->close();

    // Calculate the sum of expense for the last 30 days
    $expenseQuery = "SELECT SUM(Amount) FROM expense WHERE User_id = ? AND Received_dt >= DATE_SUB(NOW(), INTERVAL 30 DAY)";
    $expenseStmt = $conn->prepare($expenseQuery);
    $expenseStmt->bind_param("i", $userId); // Assuming Id is an integer
    $expenseStmt->execute();
    $expenseStmt->bind_result($expense_sum);
    $expenseStmt->fetch();
    $expenseStmt->close();

    // Set 'Income' and 'Expense' in the session
    $_SESSION['Income'] = $income_sum;
    $_SESSION['Expense'] = $expense_sum;
    // Set 'Balance' in the session
    $_SESSION['Balance'] = $balance;

    // Use $userId and $username to fetch and display user-specific data
} else {
    // Handle case where user information is not available
    echo "Invalid user information";
    //exit;
    header("Location: index.php");
    exit;
}
?>

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

    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="js\lib\echart\echarts-init.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:** -->
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <!-- <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div> -->
    <!-- Main wrapper  -->
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
                    <h3 class="text-primary">Finance Management System</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $_SESSION['Username']; ?></li>
                    </ol>
                </div>
            </div>
            <!-- --------------------------END BREAD CRUMB--------------------------------------- -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- ----------------------START PAGE CONTENT----------------------------------- -->
                <div class="row">
                    <!-- Balance Card -->
                    <div class="col-md-4">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-usd f-s-40 color-primary"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <?php if (isset($_SESSION['Balance'])) : ?>
                                        <h2><?php echo $_SESSION['Balance']; ?></h2>
                                    <?php else : ?>
                                        <h2>0</h2> <!-- Provide a default value or handle the case where 'Balance' is not set -->
                                    <?php endif; ?>
                                    <p class="m-b-0">Balance</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Income Card -->
                    <div class="col-md-4">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-shopping-cart f-s-40 color-success"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <?php if (isset($_SESSION['Income'])) : ?>
                                        <h2><?php echo $_SESSION['Income']; ?></h2>
                                    <?php else : ?>
                                        <h2>0</h2> <!-- Default value or handling when 'Income' is not set -->
                                    <?php endif; ?>
                                    <p class="m-b-0">Income Last 30 Days</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expense Card -->
                    <div class="col-md-4">
                        <div class="card p-30">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="fa fa-archive f-s-40 color-warning"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <?php if (isset($_SESSION['Expense'])) : ?>
                                        <h2><?php echo $_SESSION['Expense']; ?></h2>
                                    <?php else : ?>
                                        <h2>0</h2> <!-- Default value or handling when 'Expense' is not set -->
                                    <?php endif; ?>
                                    <p class="m-b-0">Expense Last 30 Days</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- --------------------------END START PAGE CONTENT------------------------------ -->

                <div class="row bg-white m-l-0 m-r-0 box-shadow ">

                    <!-- column -->
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Income and Expense Graph</h4>
                                <div id="income-expense-area-chart"></div>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Fetch data for the Morris Area chart (both income and expense)
                    $transactionChartDataQuery = "
                            SELECT DATE(transactions.Received_dt) AS date,
                                COALESCE(SUM(CASE WHEN transactions.Type = 'Income' THEN transactions.Amount ELSE 0 END), 0) AS total_income,
                                COALESCE(SUM(CASE WHEN transactions.Type = 'Expense' THEN transactions.Amount ELSE 0 END), 0) AS total_expense
                            FROM (
                                SELECT 'Income' AS Type, Received_dt, Amount FROM income WHERE User_id = ? AND Received_dt >= CURDATE() - INTERVAL 30 DAY
                                UNION ALL
                                SELECT 'Expense' AS Type, Received_dt, Amount FROM expense WHERE User_id = ? AND Received_dt >= CURDATE() - INTERVAL 30 DAY
                            ) transactions
                            GROUP BY DATE(transactions.Received_dt)
                            ORDER BY DATE(transactions.Received_dt) DESC;";


                    $transactionChartDataStmt = $conn->prepare($transactionChartDataQuery);
                    $transactionChartDataStmt->bind_param("ii", $userId, $userId); // Assuming Id is an integer
                    $transactionChartDataStmt->execute();
                    $transactionChartDataResult = $transactionChartDataStmt->get_result();

                    $transactionChartData = array();
                    while ($row = $transactionChartDataResult->fetch_assoc()) {
                        $transactionChartData[] = $row;
                    }
                    ?>

                    <!-- column -->

                    <!-- column -->
                    <div class="col-lg-5">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Categories Graph</h4>
                                <div id="chartContainer">
                                    <div id="doughnut" style="height: 400px; width: 70%;"></div>
                                    <div id="legend" style="width: 70%; margin-top: 20px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        // Fetch category distribution data for both income and expense
                        $categoryDistributionQuery = "
                            SELECT
                                c.Name,
                                COALESCE(COUNT(i.Income_id), 0) AS IncomeCount,
                                COALESCE(COUNT(e.Id), 0) AS ExpenseCount
                            FROM category c
                            LEFT JOIN income i ON c.Id = i.Category_Id AND i.User_id = ?
                            LEFT JOIN expense e ON c.Id = e.Category_id AND e.User_id = ?
                            WHERE c.User_id = ?  -- This condition ensures only categories associated with the user are considered
                            GROUP BY c.Name";

                        $categoryDistributionStmt = $conn->prepare($categoryDistributionQuery);
                        $categoryDistributionStmt->bind_param("iii", $userId, $userId, $userId);
                        $categoryDistributionStmt->execute();
                        $categoryDistributionResult = $categoryDistributionStmt->get_result();

                        $categoryData = array();

                        while ($row = $categoryDistributionResult->fetch_assoc()) {
                            $categoryData[] = array(
                                'name' => $row['Name'],
                                'value' => $row['IncomeCount'] + $row['ExpenseCount']
                            );
                        }

                        $categoryDistributionStmt->close();
                    ?>


                    <!-- <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body browser">
                                <p class="f-w-600">Grocery <span class="pull-right">85%</span></p>
                                <div class="progress ">
                                    <div role="progressbar" style="width: 85%; height:8px;" class="progress-bar bg-danger wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Shopping<span class="pull-right">90%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="width: 90%; height:8px;" class="progress-bar bg-info wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Semester Fee<span class="pull-right">65%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="width: 65%; height:8px;" class="progress-bar bg-success wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

                                <p class="m-t-30 f-w-600">Books<span class="pull-right">65%</span></p>
                                <div class="progress">
                                    <div role="progressbar" style="width: 65%; height:8px;" class="progress-bar bg-warning wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>

								<p class="m-t-30 f-w-600">Projects<span class="pull-right">65%</span></p>
                                <div class="progress m-b-30">
                                    <div role="progressbar" style="width: 65%; height:8px;" class="progress-bar bg-success wow animated progress-animated"> <span class="sr-only">60% Complete</span> </div>
                                </div>
                            </div>
                        </div>
                    </div> -->


                    <!-- column -->
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="card bg-dark">
                            <div class="testimonial-widget-one p-17">
                                <div class="testimonial-widget-one owl-carousel owl-theme">
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/2.jpg" alt="" />
                                            <div class="testimonial-author">FINANCE TRACKING SYSTEM</div>
                                            <div class="testimonial-author-position">About Our Website</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i> we curate a seamless financial experience, empowering users to sculpt personalized budgets and craft exquisite categories with ease. Dive into a world where financial management becomes an art, redefining the way you navigate and achieve your financial aspirations.
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/3.jpg" alt="" />
                                            <div class="testimonial-author">FINANCE TRACKING SYSTEM</div>
                                            <div class="testimonial-author-position">About Our Website</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i> we curate a seamless financial experience, empowering users to sculpt personalized budgets and craft exquisite categories with ease. Dive into a world where financial management becomes an art, redefining the way you navigate and achieve your financial aspirations.
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/1.jpg" alt="" />
                                            <div class="testimonial-author">FINANCE TRACKING SYSTEM</div>
                                            <div class="testimonial-author-position">About Our Website</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i> we curate a seamless financial experience, empowering users to sculpt personalized budgets and craft exquisite categories with ease. Dive into a world where financial management becomes an art, redefining the way you navigate and achieve your financial aspirations.
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/4.jpg" alt="" />
                                            <div class="testimonial-author">FINANCE TRACKING SYSTEM</div>
                                            <div class="testimonial-author-position">About Our Website</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i> we curate a seamless financial experience, empowering users to sculpt personalized budgets and craft exquisite categories with ease. Dive into a world where financial management becomes an art, redefining the way you navigate and achieve your financial aspirations.
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/5.jpg" alt="" />
                                            <div class="testimonial-author">FINANCE TRACKING SYSTEM</div>
                                            <div class="testimonial-author-position">About Our Website</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i> we curate a seamless financial experience, empowering users to sculpt personalized budgets and craft exquisite categories with ease. Dive into a world where financial management becomes an art, redefining the way you navigate and achieve your financial aspirations.
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/6.jpg" alt="" />
                                            <div class="testimonial-author">FINANCE TRACKING SYSTEM</div>
                                            <div class="testimonial-author-position">About Our Website</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i> we curate a seamless financial experience, empowering users to sculpt personalized budgets and craft exquisite categories with ease. Dive into a world where financial management becomes an art, redefining the way you navigate and achieve your financial aspirations.
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ..........................PHP-CODE.................................-->
                    <?php
                    // Assuming you have the user ID stored in a session variable
                    $userId = $_SESSION['Id'];

                    // Fetch income data for the logged-in user based on user's ID
                    $incomeQuery = "SELECT Income_id, Amount, Description, Updated_dt, Created_dt, Received_dt FROM income WHERE User_id = ?";
                    $incomeStmt = $conn->prepare($incomeQuery);

                    if (!$incomeStmt) {
                        echo "Error in preparing income query: " . $conn->error;
                        exit;
                    }

                    $incomeStmt->bind_param("i", $userId);
                    $incomeStmt->execute();

                    // Check for errors
                    if ($incomeStmt->error) {
                        echo "Error in executing income query: " . $incomeStmt->error;
                        exit;
                    }

                    $incomeResult = $incomeStmt->get_result();

                    // Close the prepared statement
                    $incomeStmt->close();
                    ?>
                    <!-- ..........................PHP-CODE.................................-->

                    <!-- Display the recent transactions table -->
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-title">
                                <h4>Recent Transactions</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                                <th>Update Date</th>
                                                <th>Created Date</th>
                                                <th>Received Date</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            error_reporting(E_ALL);
                                            ini_set('display_errors', 1);
                                            // Fetch recent 5 transactions (both income and expense)
                                            $recentTransactionsQuery = "
                                            (SELECT 'income' AS transaction_type, Amount, Description, Updated_dt, Created_dt, Received_dt
                                            FROM income
                                            WHERE User_id = ?
                                            ORDER BY Received_dt DESC
                                            LIMIT 5)
                                            UNION
                                            (SELECT 'expense' AS transaction_type, Amount, Description, Updated_dt, Created_dt, Received_dt
                                            FROM expense
                                            WHERE User_id = ?
                                            ORDER BY Received_dt DESC
                                            LIMIT 5)
                                            ORDER BY Received_dt DESC
                                            LIMIT 5";

                                            $recentTransactionsStmt = $conn->prepare($recentTransactionsQuery);
                                            $recentTransactionsStmt->bind_param("ii", $userId, $userId); // Assuming Id is an integer
                                            $recentTransactionsStmt->execute();
                                            $recentTransactionsResult = $recentTransactionsStmt->get_result();

                                            if (!$recentTransactionsResult) {
                                                die("SQL Error: " . $recentTransactionsStmt->error);
                                            }

                                            // Loop through the fetched data and display it in the table
                                            while ($row = $recentTransactionsResult->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['transaction_type'] . "</td>";
                                                echo "<td>" . $row['Amount'] . "</td>";
                                                echo "<td>" . $row['Description'] . "</td>";
                                                echo "<td>" . $row['Updated_dt'] . "</td>";
                                                echo "<td>" . $row['Created_dt'] . "</td>";
                                                echo "<td>" . $row['Received_dt'] . "</td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ..........................PHP-CODE.................................-->
                <?php
                // Retrieve user information from the session
                $user_id = $_SESSION['Id'];

                // Fetch top 5 goals from the database based on user_id in ascending order
                $sql = "SELECT name, Status FROM goals WHERE user_id = ? ORDER BY Id ASC LIMIT 5";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();

                // Fetch all goals for the logged-in user
                $stmt->bind_result($goalName, $goalStatus);
                $goals = array();
                while ($stmt->fetch()) {
                    $goals[] = array('name' => $goalName, 'status' => $goalStatus);
                }
                $stmt->close();
                ?>
                <!-- ..........................PHP-CODE.................................-->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Goals</h4>
                                <div class="card-content">
                                    <div class="todo-list">
                                        <div class="tdl-holder">
                                            <div class="tdl-content">
                                                <ul>
                                                    <?php foreach ($goals as $goal) : ?>
                                                        <li>
                                                            <label>
                                                                <input type="checkbox" <?php echo (strtolower($goal['status']) == 'done') ? 'checked' : ''; ?>>
                                                                <i class="bg-primary"></i><span><?php echo htmlspecialchars($goal['name']); ?></span>
                                                                <a href='#' class="ti-close"></a>
                                                            </label>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <input type="text" class="tdl-new form-control" placeholder="Search here">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="year-calendar"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-title">
                                        <h4>Message </h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Description</th>

                                                    </tr>
                                                </thead>
                                                <!-- Add this div where you want the table to appear -->
                                                <div id="entries-table"></div>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /# card -->
                            </div>
                        </div>
                    </div>

                </div>


                <!-- -------------------------END PAGE CONTENT---------------------------- -->
            </div>
            <!-- End Container fluid  -->
        <!-- footer -->
        <footer class="footer"> © BSCS-5B All rights reserved. Template designed by <a href="about_us.php">usman-owais-sania</a></footer>
        <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
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


    <!-- Amchart -->
    <script src="js/lib/morris-chart/raphael-min.js"></script>
    <script src="js/lib/morris-chart/morris.js"></script>


    <script src="js/lib/morris-chart/dashboard1-init.js"></script>
    <script>
        // Use window.onload to ensure the HTML content is fully loaded
        window.onload = function() {
            Morris.Area({
                element: 'income-expense-area-chart',
                data: <?php echo json_encode($transactionChartData); ?>,
                xkey: 'date',
                ykeys: ['total_income', 'total_expense'],
                labels: ['Total Income', 'Total Expense'],
                pointSize: 3,
                fillOpacity: 0.4,
                pointStrokeColors: ['#4680ff', '#fc6180'],
                behaveLikeLine: true,
                gridLineColor: '#e0e0e0',
                lineWidth: 3,
                hideHover: 'auto',
                lineColors: ['#4680ff', '#fc6180'],
                resize: true
            });
        };
    </script>

    <script src="https://cdn.jsdelivr.net/npm/echarts@5.2.1/dist/echarts.min.js"></script>
    <script>
        var dom = document.getElementById("doughnut");
        var legendDom = document.getElementById("legend");

        var dnutChart = echarts.init(dom);

        var option = {
            color: ['#62549a', '#4aa9e9', '#ff6c60', '#eac459', '#25c3b2'],
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
                data: <?php echo json_encode(array_column($categoryData, 'name')); ?>
            },
            calculable: true,
            series: [{
                name: 'Category',
                type: 'pie',
                radius: ['50%', '70%'],
                data: <?php echo json_encode($categoryData); ?>
            }]
        };

        var legendOption = {
            orient: 'horizontal',
            data: <?php echo json_encode(array_column($categoryData, 'name')); ?>
        };

        if (option && typeof option === "object") {
            dnutChart.setOption(option, false);
        }

        if (legendOption && typeof legendOption === "object") {
            var legendChart = echarts.init(legendDom);
            legendChart.setOption(legendOption, false);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.my-calendar').pignoseCalendar({
                select: function(date, obj) {
                    // Send an asynchronous request to the server with the selected date
                    $.ajax({
                        type: 'POST',
                        url: 'get_entries.php', // Replace with the actual server-side script to fetch entries
                        data: {
                            selectedDate: date.format('YYYY-MM-DD')
                        },
                        success: function(response) {
                            // Update the table with the fetched entries
                            $('#entries-table').html(response);
                        },
                        error: function(error) {
                            console.log('Error fetching entries:', error);
                        }
                    });
                }
            });
        });
    </script>


    <script src="js/lib/calendar-2/moment.latest.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/semantic.ui.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/prism.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/pignose.calendar.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/pignose.init.js"></script>

    <script src="js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/lib/owl-carousel/owl.carousel-init.js"></script>
    <script src="js/scripts.js"></script>
    <!-- scripit init-->

    <script src="js/custom.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="js/lib/toastr/toastr.init.js"></script>



</body>

</html>