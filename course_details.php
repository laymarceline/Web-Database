<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School - Course Details Page</title>

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
    <li style="float:right"><a class="active" href="courses.php">Courses</a></li>
    <li style="float:right"><a href="students.php">Students</a></li>

</ul>
<p><a href="courses.php">&#8592; Courses</a></p>
<br>
<?php

require('connection.php');
/** @var PDO $dbh Database connection */

if (isset($_GET['id'])) {
    $course_stmt = $dbh->prepare("SELECT * FROM `course` WHERE `course_id` = ?");
    if ($course_stmt->execute([$_GET['id']]) && $course_stmt->rowCount() > 0) {
        $course = $course_stmt->fetchObject();
    } else {
        header('Location: course.php');
    }
} else {
    header('Location: course.php');
}

?>
<div class = "center">
    <h1>Course Details </h1>
    <table>
        <tr>
            <td>Course ID&nbsp;:&nbsp;</td>
            <td><?= $course->course_id ?></td>
        </tr>
        <tr>
            <td>Course Name&nbsp;:&nbsp;</td>
            <td><?= $course->course_name ?></td>
        </tr>
        <tr>
            <td>Course Price&nbsp;:&nbsp;</td>
            <td><?= $course->course_price ?></td>
        </tr>
        <tr>
            <td>Category ID&nbsp;:&nbsp;</td>
            <td><?= $course->category_id ?></td>
        </tr>
    </table>

    <?php
    $image_stmt = $dbh->prepare("SELECT * FROM `course_image` WHERE `course_id` = ?");
    if ($image_stmt->execute([$course->course_id]) && $image_stmt->rowCount() > 0) {
        $course_image = $image_stmt->fetchObject(); ?>
        <div class="row">
            <br>
            <label for="image">Course Images</label>
            <p><img width="400" height="300" src="course_images/<?= $course_image->file_path ?>"/></p>
        </div>
    <?php } ?>
</div>
</body>

<p><a href="courses.php">&#8592; Courses</a></p>

</html>