<?php ob_start();
session_start();
include("connection.php");
/** @var PDO $dbh */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School</title>

    <meta name="description" content="2022 S2 Assignment">
    <meta name="author" content="FIT2104 Web Database Interface">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<ul>
    <a href = "index.html"><img width="240" height="70" src = "images/a2_logo.png"></a>
    <li style="float:right"><a class = "active" href="login.php">Login</a></li>
    <li style="float:right"><a href="contact_us.php">Contact Us</a></li>
    <li style="float:right"><a href="about_us.php">About Us</a></li>
</ul>
<p><a href="index.html">&#8592; Home</a></p>
<br><br><br><br><br><br><br><br>
<center>
    <img width="480" height="140" src = "images/a2_logo.png">
    <h1>Please Login!</h1>
</center>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['uname']) && !empty($_POST['psw'])) {
        $stmt = $dbh->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
        if ($stmt->execute([
                $_POST['uname'],
                hash('sha256', $_POST['psw'])
            ]) && $stmt->rowCount() == 1) {
            $row = $stmt->fetchObject();
            $_SESSION['username'] = $row->username;
            //Successfully logged in, redirect user to dashboard
            header("Location: dashboard.php");
        } else {
            echo "<center><h2>Either username or password is incorrect! Please Try Again!</h2></center>";
        }
    }
}  else {
    if (isset($_SESSION['username'])) {
        $user_stmt = $dbh->prepare("SELECT * FROM `users` WHERE `username` = ?");
        if ($user_stmt->execute([$_SESSION['username']]) && $user_stmt->rowCount() == 1) {
            //User already logged in, redirect user to dashboard
            header("Location: dashboard.php");
        } else {
            echo "<h1>Your account does not exist!</h1>";
            session_destroy();
        }
    }
}
?>
<center>
    <form method="post">
        <label for="uname">Username</label>
        <input type="text" id="uname" name="uname"/>
        <br><br>
        <label for="psw">Password</label>
        <input type="password" id="psw" name="psw"/>
        <br><br>
        <input type="submit" value="Login"/>
    </form>
</center>
</body>
</html>
