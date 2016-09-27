<!DOCTYPE html>
<html lang="en">

<head>
    <title>DeliVariety</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/stylesheet.css" rel="stylesheet">
</head>

<body>
<div class="otherHeader">
    <img class="shape" src="img/restaurant_overview_shape.png" alt="shape">
    <div class="bgCanvas">
        <div class="otherBanner row">
            <div class="logoMenu col-md-4">
                <a href="index.html"><img src="img/logo.png" alt="logo"></a>
                <div class="btnMenu">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                    <button class="labelMenu" type="button">MENU</button>
                </div>
            </div>
            <div class="btnRegister col-md-4 pull-right">
                <a href="registration.php">Sign Up</a>
                <a href="login.php">Log In</a>
            </div>
        </div>
        <h5>Welcome Back</h5>
    </div>
</div>

<?php
require_once('connectvars.php');
session_start();
$error_msg = "";

if (!isset($_SESSION['user_id'])) {
    if (isset($_POST['submit'])) {
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user_name = mysqli_real_escape_string($dbc, $_POST['username']);
        $password = mysqli_real_escape_string($dbc, $_POST['password']);

        if (!empty($user_name) && !empty($password)) {
            $query = "SELECT user_id, user_name FROM DV_USER WHERE user_name = '$user_name'";
            $result = mysqli_query($dbc, $query);

            if (mysqli_num_rows($result) == 1) {
                $data = mysqli_fetch_array($result);
                $_SESSION['user_id'] = $data['user_id'];
                $_SESSION['username'] = $data['username'];
                setcookie('user_id', $data['user_id']);
                setcookie('username', $data['username']);
                $menu_url = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '/menu.php';
                header('Location: ' . $menu_url);

            } else {
                $error_msg = 'Sorry, you have entered an invalid username or password';
            }
        } else {
            $error_msg = 'You must enter username and password to log in.';
        }
    }
}
?>

<?php
if (empty($_SESSION['user_id'])) {
    echo $error_msg;
    ?>
    <!--login form-->
    <div class="signUpForm col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-sm-6 col-sm-offset-3">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" class="form-horizontal">
            <fieldset>
                <legend>Enter Your Login Information:</legend>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="username">Username:</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" placeholder="Enter username"
                               value="<?php if (!empty($user_name)) echo $user_name ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-3" for="password">Password:</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" placeholder="Enter password"
                               value="<?php if (!empty($password)) echo $password ?>">
                    </div>
                </div>
            </fieldset>
            <br>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-default">Log In</button>
                </div>
            </div>
        </form>
    </div>
    <?php
} else {
    echo 'Welcome back! ' . $_SESSION['username'] . '.';
}
?>

<div id="bottom" class="bottom">
    <div class="social">
        <div class="follow"><img src="img/logo_facebook.png" alt="facebook"></div>
        <div class="follow"><img src="img/logo_instagram.png" alt="instagram"></div>
        <div class="follow"><img src="img/logo_twitter.png" alt="twitter"></div>
        <p>You are always welcomed to join us and follow us to get the latest offers</p>
    </div>
    <div class="copyright">
        <p>© DeliVariety Food & Catering. All Rights Reserved.</p>
    </div>
</div>

<!--overlay for the menu-->
<div class="overlay">
    <div class="btnClose col-md-4 col-sm-4 col-xs-4">
        <i class="fa fa-times" aria-hidden="true"></i>
    </div>
    <div class="navContainer col-md-4 col-sm-4 col-xs-4">
        <ul class="navbar">
            <li><a href="index.html">Home</a></li>
            <li><a href="menu.php">Food Menu</a></li>
            <li><a href="reservation.php">Reservation</a></li>
            <li><a href="contact.html">Contact</a></li>
        </ul>
        <div class="btnRegOverlay">
            <a href="registration.php">Sign Up</a>
            <a href="#">Log In</a>
        </div>
    </div>
</div>

<div class="scrollUp">
    <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
</div>

<script src="https://use.fontawesome.com/5a79a0d633.js"></script>
<script src="js/main.js"></script>

</body>
</html>