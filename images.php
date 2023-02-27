<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

// Read all courses
$stmt = $dbh->prepare("SELECT * FROM `course_image`;");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School - Images Page</title>

    <meta name="description" content="2022 S2 Assignment">
    <meta name="author" content="FIT2104 Web Database Interface">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<ul>
    <a href = "index.html"><img width="240" height="70" src = "images/a2_logo.png"></a>
    <li style="float:right"><a class = "active" href="images.php">Course Images</a></li>
    <li style="float:right"><a href="tailored_classes/tailored_classes.php">Tailored Classes</a></li>
    <li style="float:right"><a href="categories/category.php">Category</a></li>
    <li style="float:right"><a href="courses.php">Courses</a></li>
    <li style="float:right"><a href="students.php">Students</a></li>

</ul>
<p><a href="dashboard.php">&#8592; Dashboard</a></p>
<br>
<div>
    <?php
    if ($stmt->execute() && $stmt->rowCount() > 0): //execute if data exists ?>
    <form method="post" action="course_images_delete.php" id="courses-delete-form">
        <center><h1>Course Images</h1></center>
        <input class = "button"type="submit" value="Delete selected images" class="delete-all">
        <br><br>
        <table class = "student-table">
            <thead>
            <tr>
                <th>Select</th>
                <th>Course Image ID</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetchObject()): ?>
                <tr>
                    <td><input type="checkbox" name="course_image_ids[]" class="course-image-delete" value="<?php echo $row->course_image_id; ?>"/></td>
                    <td><?= $row->course_image_id; ?></td>
                    <td><img width="400" height="300" src="course_images/<?= $row->file_path ?>"/></td>
                    <td>
                        <a href="images_delete.php?id=<?= $row->course_image_id ?>" class = "delete-course-image" onclick="return confirm('Are you sure you want to delete this course image?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </form>
    <?php else: ?>
        <p>There's no data in course image</p>
    <?php endif; ?>
    <br>
</div>
<p><a href="dashboard.php">&#8592; Dashboard</a></p>
</body>
</html>