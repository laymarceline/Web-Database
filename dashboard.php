<?php
session_start();
include("connection.php");
/** @var PDO $dbh */

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer Music School</title>

    <meta name="description" content="2022 S2 Assignment">
    <meta name="author" content="FIT2104 Web Database Interface">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<ul>
    <a href = "index.html"><img width="240" height="70" src = "images/a2_logo.png"></a>
</ul>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    session_destroy();
    header("Location: login.php");
} else {
    if (isset($_SESSION['username'])) {
        $user_stmt = $dbh->prepare("SELECT * FROM `users` WHERE `username` = ?");
        if ($user_stmt->execute([$_SESSION['username']]) && $user_stmt->rowCount() == 1) {
            $user = $user_stmt->fetchObject();
            echo "<center>";
            echo "<h1>Welcome " . $user->username . ", you're already logged in!</h1>";
            echo "<a href='?action=logout'>Click here to logout</a>";
            echo "</center><br>";
        } else {
            echo "<h1>Your account does not exist!</h1>";
            session_destroy();
        }
    } else {
        echo "<center>";
        echo "<h1>Please Login first!</h1>";
        echo "<a href='login.php'>Click here to login</a>";
        echo "</center><br>";
    }
}
?>
<h1><center>Little Dreamer's Music School Dashboard</center></h1>
<center>
    <a href="students.php">Students</a>&nbsp;
    <a href="courses.php">Courses</a>&nbsp;
    <a href="categories/category.php">Category</a>&nbsp;
    <a href="tailored_classes/tailored_classes.php">Tailored Classes</a>&nbsp;
    <a href="images.php">Images</a>
</center>
</body>
</html>
