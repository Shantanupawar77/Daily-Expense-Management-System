<?php
  include("session.php");
  $exp_category_dc = mysqli_query($con, "SELECT expensecategory FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");
  $exp_amt_dc = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensecategory");

  $exp_date_line = mysqli_query($con, "SELECT expensedate FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
  $exp_amt_line = mysqli_query($con, "SELECT SUM(expense) FROM expenses WHERE user_id = '$userid' GROUP BY expensedate");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense Mangement System</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Feather JS for Icons -->
    <script src="js/feather.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
    .card a {
        color: #000;
        font-weight: 500;
    }

    .card a:hover {
        color: #28a745;
        text-decoration: dotted;
    }

    :root {
        --font-family-sans-serif: "Open Sans", -apple-system, BlinkMacSystemFont,
            "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
            "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }

    *,
    *::before,
    *::after {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    html {
        font-family: sans-serif;
        line-height: 1.15;
        -webkit-text-size-adjust: 100%;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    }

    nav {
        display: block;
    }

    body {
        margin: 0;
        font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI",
            Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji",
            "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #515151;
        text-align: left;
        background-color: #e9edf4;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        margin-top: 0;
        margin-bottom: 0.5rem;
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem;
    }

    a {
        color: #3f84fc;
        text-decoration: none;
        background-color: transparent;
    }

    a:hover {
        color: #0458eb;
        text-decoration: underline;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
        font-family: "Nunito", sans-serif;
        margin-bottom: 0.5rem;
        font-weight: 500;
        line-height: 1.2;
    }

    h1,
    .h1 {
        font-size: 2.5rem;
        font-weight: normal;
    }

    .card {
        position: relative;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0;
    }

    .card-body {
        -webkit-box-flex: 1;
        -webkit-flex: 1 1 auto;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .card-header {
        padding: 0.75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, 0.03);
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        text-align: center;
    }

    .dashboard {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        min-height: 100vh;
    }

    .dashboard-app {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-flex: 2;
        -webkit-flex-grow: 2;
        -ms-flex-positive: 2;
        flex-grow: 2;
        margin-top: 84px;
    }

    .dashboard-content {
        -webkit-box-flex: 2;
        -webkit-flex-grow: 2;
        -ms-flex-positive: 2;
        flex-grow: 2;
        padding: 25px;
    }

    .dashboard-nav {
        min-width: 238px;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        overflow: auto;
        background-color: #373193;
    }

    .dashboard-compact .dashboard-nav {
        display: none;
    }

    .dashboard-nav header {
        min-height: 84px;
        padding: 8px 27px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .dashboard-nav header .menu-toggle {
        display: none;
        margin-right: auto;
    }

    .dashboard-nav a {
        color: #515151;
    }

    .dashboard-nav a:hover {
        text-decoration: none;
    }

    .dashboard-nav {
        background-color: #443ea2;
    }

    .dashboard-nav a {
        color: #fff;
    }

    .brand-logo {
        font-family: "Nunito", sans-serif;
        font-weight: bold;
        font-size: 20px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        color: #515151;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
    }

    .brand-logo:focus,
    .brand-logo:active,
    .brand-logo:hover {
        color: #dbdbdb;
        text-decoration: none;
    }

    .brand-logo i {
        color: #d2d1d1;
        font-size: 27px;
        margin-right: 10px;
    }

    .dashboard-nav-list {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .dashboard-nav-item {
        min-height: 56px;
        padding: 8px 20px 8px 70px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        letter-spacing: 0.02em;
        transition: ease-out 0.5s;
    }

    .dashboard-nav-item i {
        width: 36px;
        font-size: 19px;
        margin-left: -40px;
    }

    .dashboard-nav-item:hover {
        background: rgba(255, 255, 255, 0.04);
    }

    .active {
        background: rgba(0, 0, 0, 0.1);
    }

    .dashboard-nav-dropdown {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .dashboard-nav-dropdown.show {
        background: rgba(255, 255, 255, 0.04);
    }

    .dashboard-nav-dropdown.show>.dashboard-nav-dropdown-toggle {
        font-weight: bold;
    }

    .dashboard-nav-dropdown.show>.dashboard-nav-dropdown-toggle:after {
        -webkit-transform: none;
        -o-transform: none;
        transform: none;
    }

    .dashboard-nav-dropdown.show>.dashboard-nav-dropdown-menu {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
    }

    .dashboard-nav-dropdown-toggle:after {
        content: "";
        margin-left: auto;
        display: inline-block;
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid rgba(81, 81, 81, 0.8);
        -webkit-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .dashboard-nav .dashboard-nav-dropdown-toggle:after {
        border-top-color: rgba(255, 255, 255, 0.72);
    }

    .dashboard-nav-dropdown-menu {
        display: none;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -webkit-flex-direction: column;
        -ms-flex-direction: column;
        flex-direction: column;
    }

    .dashboard-nav-dropdown-item {
        min-height: 40px;
        padding: 8px 20px 8px 70px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        transition: ease-out 0.5s;
    }

    .dashboard-nav-dropdown-item:hover {
        background: rgba(255, 255, 255, 0.04);
    }

    .menu-toggle {
        position: relative;
        width: 42px;
        height: 42px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        color: #443ea2;
    }

    .menu-toggle:hover,
    .menu-toggle:active,
    .menu-toggle:focus {
        text-decoration: none;
        color: #875de5;
    }

    .menu-toggle i {
        font-size: 20px;
    }

    .dashboard-toolbar {
        min-height: 84px;
        background-color: #dfdfdf;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 8px 27px;
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1000;
    }

    .nav-item-divider {
        height: 1px;
        margin: 1rem 0;
        overflow: hidden;
        background-color: rgba(236, 238, 239, 0.3);
    }

    @media (min-width: 992px) {
        .dashboard-app {
            margin-left: 238px;
        }

        .dashboard-compact .dashboard-app {
            margin-left: 0;
        }
    }


    @media (max-width: 768px) {
        .dashboard-content {
            padding: 15px 0px;
        }
    }

    @media (max-width: 992px) {
        .dashboard-nav {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            z-index: 1070;
        }

        .dashboard-nav.mobile-show {
            display: block;
        }
    }

    @media (max-width: 992px) {
        .dashboard-nav header .menu-toggle {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
        }
    }

    @media (min-width: 992px) {
        .dashboard-toolbar {
            left: 238px;
        }

        .dashboard-compact .dashboard-toolbar {
            left: 0;
        }
    }

    /* Your existing CSS styles */

    .dashboard-app {
        /* Center the dashboard content */
        margin-top: 84px;
        /* Adjust as needed */
    }

    .dashboard-nav {
        /* Adjust the background color and font color */
        background-color: #443ea2;
        color: #fff;
    }

    .dashboard-nav-list .dashboard-nav-item {
        /* Add padding and hover effect */
        padding: 8px 20px;
        transition: background-color 0.3s ease-in-out;
    }

    .dashboard-nav-list .dashboard-nav-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .dashboard-nav-list .dashboard-nav-item.active {
        /* Highlight the active item */
        background-color: rgba(0, 0, 0, 0.1);
    }

    .dashboard-nav header .menu-toggle {
        /* Style the menu toggle button */
        display: block;
        position: absolute;
        top: 15px;
        left: 15px;
        color: #fff;
        font-size: 20px;
    }

    .dashboard-nav .brand-logo {
        /* Adjust the brand logo */
        color: #fff;
    }

    .dashboard-content {
        /* Adjust padding */
        padding: 25px;
    }

    /* Media query for small screens */
    @media (max-width: 992px) {
        .dashboard-nav {
            /* Adjust the positioning */
            position: fixed;
            top: 0;
            bottom: 0;
            z-index: 1070;
            width: 238px;
            /* Adjust as needed */
        }

        .dashboard-app {
            /* Adjust the margin */
            margin-top: 0;
            margin-left: 0;
        }

        .dashboard-nav.mobile-show {
            display: block;
        }

        .dashboard-nav header .menu-toggle {
            display: block;
        }
    }

    /* Media query for large screens */
    @media (min-width: 992px) {
        .dashboard-toolbar {
            /* Adjust the positioning */

            left: 238px;
            /* Adjust as needed */
        }
    }
    </style>
</head>

<body>
    <div class='dashboard'>
        <div class="dashboard-nav">
            <div class="user">
                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="120">
                <h5>
                    <?php echo $username ?>
                </h5>
                <p>
                    <?php echo $useremail ?></p>
            </div>


            <nav class="dashboard-nav-list"><a href="index.php" class="dashboard-nav-item"><i class="fas fa-home"></i>
                    Dashboard </a><a href="add_expense.php" class="dashboard-nav-item active"><i
                        class="fas fa-tachometer-alt"></i>
                    Add Expenses
                </a><a href="manage_expense.php" class="dashboard-nav-item"><i class="fas fa-file-upload"></i> Manage
                    Expenses </a>
                <a href="profile.php" class="dashboard-nav-item"><i class="fas fa-user"></i> Profile </a>
                <div class="nav-item-divider"></div>
                <a href="logout.php" class="dashboard-nav-item"><i class="fas fa-sign-out-alt"></i> Logout </a>
            </nav>
        </div>
        <div class='dashboard-app'>
            <!-- <nav class="navbar navbar-expand-lg navbar-light  border-bottom">

                <button class="toggler" type="button" id="menu-toggle" aria-expanded="false">
                    <span data-feather="menu"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <nav>

                    </nav>
                    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Your Profile</a>
                                <a class="dropdown-item" href="#">Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav> -->
            <nav class="navbar navbar-expand-lg navbar-light border-bottom">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto mt-0 mt-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img img-fluid rounded-circle" src="<?php echo $userprofile ?>" width="25">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href=profile.php">Your Profile</a>
                                <a class="dropdown-item" href="profile.php">Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>



            <div class='dashboard-content'>
                <div class='container'>
                    <div class="container-fluid">
                        <h3 class="mt-4">Dashboard</h3>
                        <div class="row">
                            <div class="col-md">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col text-center">
                                                <a href="add_expense.php"><img src="icon/addex.png" width="57px" />
                                                    <p>Add Expenses</p>
                                                </a>
                                            </div>
                                            <div class="col text-center">
                                                <a href="manage_expense.php"><img src="icon/maex.png" width="57px" />
                                                    <p>Manage Expenses</p>
                                                </a>
                                            </div>
                                            <div class="col text-center">
                                                <a href="profile.php"><img src="icon/prof.png" width="57px" />
                                                    <p>User Profile</p>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3 class="mt-4">Full-Expense Report</h3>
                        <div class="row">
                            <div class="col-md">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title text-center">Yearly Expenses</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="expense_line" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title text-center">Expense Category</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="expense_category_pie" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.slim.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/Chart.min.js"></script>
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
    <script>
    feather.replace()
    </script>
    <script>
    var ctx = document.getElementById('expense_category_pie').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [<?php while ($a = mysqli_fetch_array($exp_category_dc)) {
                    echo '"' . $a['expensecategory'] . '",';
                  } ?>],
            datasets: [{
                label: 'Expense by Category',
                data: [<?php while ($b = mysqli_fetch_array($exp_amt_dc)) {
                    echo '"' . $b['SUM(expense)'] . '",';
                  } ?>],
                backgroundColor: [
                    '#6f42c1',
                    '#dc3545',
                    '#28a745',
                    '#007bff',
                    '#ffc107',
                    '#20c997',
                    '#17a2b8',
                    '#fd7e14',
                    '#e83e8c',
                    '#6610f2'
                ],
                borderWidth: 1
            }]
        }
    });

    var line = document.getElementById('expense_line').getContext('2d');
    var myChart = new Chart(line, {
        type: 'line',
        data: {
            labels: [<?php while ($c = mysqli_fetch_array($exp_date_line)) {
                    echo '"' . $c['expensedate'] . '",';
                  } ?>],
            datasets: [{
                label: 'Expense by Month (Whole Year)',
                data: [<?php while ($d = mysqli_fetch_array($exp_amt_line)) {
                    echo '"' . $d['SUM(expense)'] . '",';
                  } ?>],
                borderColor: [
                    '#adb5bd'
                ],
                backgroundColor: [
                    '#6f42c1',
                    '#dc3545',
                    '#28a745',
                    '#007bff',
                    '#ffc107',
                    '#20c997',
                    '#17a2b8',
                    '#fd7e14',
                    '#e83e8c',
                    '#6610f2'
                ],
                fill: false,
                borderWidth: 2
            }]
        }
    });
    </script>
</body>

</html>