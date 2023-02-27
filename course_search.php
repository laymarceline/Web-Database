<?php
include("connection.php");

/** @var PDO $dbh Database connection */
$query = $_GET['search_query'];

$res = $dbh->prepare("SELECT * FROM `course`
			WHERE (`course_id` LIKE '%".$query."%') OR (`course_name` LIKE '%".$query."%')") or die(mysql_error());


if ($res->execute() && $res->rowCount() > 0): //execute if data exists

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Little Dreamer's Music School - Categories Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
<div class="container">
    <h3>Course search results</h3>
    <br/><br/>
    <div class="table-responsive">

        <table>
            <thead>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Course Price</th>
                <th>Course Category ID</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $res->fetchObject()): ?>
                <tr>
                    <td><?php echo $row->course_id; ?></td>
                    <td><?php echo $row->course_name; ?></td>
                    <td><?php echo $row->course_price; ?></td>
                    <td><?php echo $row->category_id; ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <h3>Course search results</h3>
            <br/><br/>
            <p>No results found</p>
        <?php endif; ?>

</body>
</html>

