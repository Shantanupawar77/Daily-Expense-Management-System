<?php
include("session.php");
$exp_fetched = mysqli_query($con, "SELECT * FROM expenses WHERE user_id = '$userid'");

if (isset($_POST['save'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];

    $sql = "UPDATE users SET firstname = '$fname', lastname='$lname' WHERE user_id='$userid'";
    if (mysqli_query($con, $sql)) {
        echo "Records were updated successfully.";
    } else {
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($con);
    }
    header('location: profile.php');
}

if (isset($_POST['but_upload'])) {

    $name = $_FILES['file']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    // Select file type
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Valid file extensions
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    // Check extension
    if (in_array($imageFileType, $extensions_arr)) {

        // Insert record
        $query = "UPDATE users SET profile_path = '$name' WHERE user_id='$userid'";
        mysqli_query($con, $query);

        // Upload file
        move_uploaded_file($_FILES['file']['tmp_name'], $target_dir . $name);

        header("Refresh: 0");
    }
}

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
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h3 class="mt-4 text-center">Update Profile</h3>
                    <hr>
                    <form class="form" method="post" action="" enctype='multipart/form-data'>
                        <div class="text-center mt-3">
                            <img src="<?php echo $userprofile; ?>"
                                class="text-center img img-fluid rounded-circle avatar" width="120"
                                alt="Profile Picture">
                        </div>
                        <div class="input-group col-md mb-3 mt-3">
                            <div class="custom-file">
                                <input type="file" name='file' class="custom-file-input" id="profilepic"
                                    aria-describedby="profilepicinput">
                                <label class="custom-file-label" for="profilepic">Change Photo</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-secondary" type="submit" name='but_upload'
                                    id="profilepicinput">Upload Picture</button>
                            </div>
                        </div>


                    </form>



                    <form class="form" action="" method="post" id="registrationForm" autocomplete="off">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">

                                    <div class="col-md">
                                        <label for="first_name">
                                            First name
                                        </label>
                                        <input type="text" class="form-control" name="first_name" id="first_name"
                                            placeholder="First Name" value="<?php echo $firstname; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">

                                    <div class="col-md">
                                        <label for="last_name">
                                            Last name
                                        </label>
                                        <input type="text" class="form-control" name="last_name" id="last_name"
                                            value="<?php echo $lastname; ?>" placeholder="Last Name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-md">
                                <label for="email">
                                    Email
                                </label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="<?php echo $useremail; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md">
                                <br>
                                <button class="btn btn-block btn-md btn-primary" style="border-radius:0%;" name="save"
                                    type="submit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                    <!--/tab-content-->

                </div>
                <!--/col-9-->
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

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
    <script type="text/javascript">
    $(document).ready(function() {


        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function() {
            readURL(this);
        });
    });
    </script>
</body>

</html>