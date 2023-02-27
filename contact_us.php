<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Little Dreamer's Music School - Contact Us Page</title>

  <meta name="description" content="2022 S2 Assignment">
  <meta name="author" content="FIT2104 Web Database Interface">

  <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed&display=swap" rel="stylesheet"/>
</head>
<body>
<ul>
  <a href = "index.html"><img width="240" height="70" src = "images/a2_logo.png"></a>
  <li style="float:right"><a href="login.php">Login</a></li>
  <li style="float:right"><a class = "active" href="contact_us.php">Contact Us</a></li>
  <li style="float:right"><a href="about_us.php">About Us</a></li>
</ul>
<p><a href="index.html">&#8592; Home</a></p>
<h1>Contact Us</h1>
<p></p>
</body>

</html>

<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

if(isset($_POST['submit'])){
    $to = "contact_littledreamermusic@example.com"; // email address to send to
    $full_name = $_POST['full_name'];
    $email = $_POST['email']; // FROM this email address
    $phone = $_POST['phone_number']; // FROM this phone number

    $subject = "Contact Us submission";

    $message = $full_name . " sent a message: " . $_POST['message'];

    $headers = "From:" . $email; // from email address
    $header2 = "Phone Number: " . $phone;

    mail($to, $subject, $message, $headers, $header2);
    echo "Email sent successfully! Please allow 24 hours for a response.";
    }
?>

<!DOCTYPE html>
<head>
<title>Contact Us</title>
</head>
<body>

<form action="" method="post">
    Full Name: <input type="text" name="full_name"><br>
    <br>
    Email: <input type="text" name="email"><br>
    <br>
    Phone Number: <input type="text" name="phone_number"><br>
    <br>
    Message:<br><textarea rows="5" name="message" cols="50"></textarea><br>
    <br>
<input type="submit" name="submit" value="Submit">
</form>
<script src="scripts.js" type="application/javascript"></script>
</body>
</html>