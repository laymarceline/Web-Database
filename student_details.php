<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Student details - Little Dreamer's Music School</title>

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
<br> <br>
<?php

require('connection.php');

/** @var PDO $dbh Database connection */

if (isset($_GET['id'])) {
    // Read the course by given id
    $student_stmt = $dbh->prepare("SELECT * FROM `student` WHERE `student_id` = ?");
    if ($student_stmt->execute([$_GET['id']]) && $student_stmt->rowCount() > 0) {
        $student = $student_stmt->fetchObject();
    } else {
        // Only available if id is given
        header('Location: students.php');
    }
} else {
    // Only available if id is given
    header('Location: students.php');
}

?>
<div class = "center">
    <h1>Student Details</h1>
    <table class = "student">
        <tr>
            <td>Student ID&nbsp;:&nbsp;</td>
            <td><?= $student->student_id ?></td>
        </tr>
        <tr>
            <td>First Name&nbsp;:&nbsp;</td>
            <td><?= $student->first_name ?></td>
        </tr>
        <tr>
            <td>Surname&nbsp;:&nbsp;</td>
            <td><?= $student->surname ?></td>
        </tr>
        <tr>
            <td>Address&nbsp;:&nbsp;</td>
            <td><?= $student->address ?></td>
        </tr>
        <tr>
            <td>Phone&nbsp;:&nbsp;</td>
            <td><?= $student->phone ?></td>
        </tr>
        <tr>
            <td>Date of Birth&nbsp;:&nbsp;</td>
            <td><?= $student->dob ?></td>
        </tr>
        <tr>
            <td>Email&nbsp;:&nbsp;</td>
            <td><a href="mailto:<?= $student->email ?>" ><?= $student->email ?></a></td>
        </tr>
        <tr>
            <td>Subscription&nbsp;:&nbsp;</td>
            <td>
                <?php if($student->subscribe == 1){
                    echo("Yes");
                } else{
                    echo("No");
                }?>
            </td>
        </tr>
    </table>
</div>
</body>
</html>