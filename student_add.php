<?php

require('connection.php');

/** @var PDO $dbh Database connection */

// primary key increment for course_id
$query = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'fit2104_a2' AND TABLE_NAME='student'";
$stmt = $dbh->prepare($query);
$nextId = ($stmt->execute() || $stmt->rowCount() > 0) ? $stmt->fetchObject()->AUTO_INCREMENT : "Not available";

// Process login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        !empty($_POST['firstname']) &&
        is_string($_POST['firstname']) &&
        !empty($_POST['surname']) &&
        is_string($_POST['surname']) &&
        !empty($_POST['address']) &&
        is_string($_POST['address']) &&
        !empty($_POST['phone']) &&
        is_string($_POST['phone']) &&
        !empty($_POST['dob']) &&
        !empty($_POST['email']) &&
        is_string($_POST['email'])
    ) {
        $_POST['subscribe'] = (int)$_POST['subscribe'];
        // Insert Data to Student table
        $stmt = $dbh->prepare("INSERT INTO `student` (`student_id`, `first_name`, `surname`, `address`,`phone`, `dob`, `email`, `subscribe`) VALUE (:student_id, :firstname, :surname, :address, :phone, :dob, :email, :subscribe)");
        if ($stmt->execute([
            'student_id' => $nextId,
            'firstname' => $_POST['firstname'],
            'surname' => $_POST['surname'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'dob' => $_POST['dob'],
            'email' => $_POST['email'],
            'subscribe' => $_POST['subscribe']
        ])) {
            // If the query executed successfully, back to the course list
            header("Location: students.php");
        } else {
            header("Location: student_add.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('The new student cannot be added. Please try again!'));
        }
    } else {
        header("Location: student_add.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('Make sure the form is valid before send!'));
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add student - Little Dreamer's Music School</title>

    <meta name="description" content="2022 S2 Assignment">
    <meta name="author" content="FIT2104 Web Database Interface">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<ul>
    <a href = "index.html"><img width="240" height="70" src = "images/a2_logo.png"></a>
    <li style="float:right"><a href="images.php">Course Images</a></li>
    <li style="float:right"><a href="tailored_classes/tailored_classes.php">Tailored Classes</a></li>
    <li style="float:right"><a href="categories/category.php">Category</a></li>
    <li style="float:right"><a href="courses.php">Courses</a></li>
    <li style="float:right"><a class="active" href="students.php">Students</a></li>
</ul>
<p><a href="students.php">&#8592; Students</a></p>
<h1>Add a new student</h1>
<div class="center">
    <!-- Show error message if it comes with the redirect-->
    <?php if (!empty($_GET['error'])): ?>
        <p class="error"><?= $_GET['error'] ?></p>
    <?php endif; ?>

    <!--Add a Student Form-->
    <form method="post">
        <div class="row">
            <label for="student_id">Student ID</label>
            <input type="number" id="student_id" name = "student_id" value="<?= $nextId ?>" disabled/>
        </div><br>
        <div class="row">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" maxlength="50" required/>
        </div><br>
        <div class="row">
            <label for="surname">Last Name</label>
            <input type="text" id="surname" name="surname" maxlength="20" required/>
        </div><br>
        <div class="row">
            <label for="address">Address</label>
            <input type="text" id="address" name="address" maxlength="100" required/>
        </div><br>
        <div class="row">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" maxlength="15" required/>
        </div><br>
        <div class="row">
            <label for="dob">Date of Birth</label>
            <input type="date" id="dob" name="dob" required/>
        </div><br>
        <div class="row">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" maxlength="80" required/>
        </div><br>
        <div class="row">
            <label for="subscribe">Subscribe</label>
            <select name="subscribe" id="subscribe">
                <option value= 1>Yes</option>
                <option value= 0>No</option>
            </select>
        </div><br>
        <div class="row center">
            <input type="submit" value="Add"/>
        </div>
    </form>
</div>
</body>
</html>