<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

// Read all courses
$stmt = $dbh->prepare("SELECT * FROM `course`;");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School - Course Page</title>

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
<p><a href="dashboard.php">&#8592; Dashboard</a></p>
<br>
<center><h1>Courses</h1> </center>


<div class="topnav">
    <body><b>Search Courses</b><br></body>

    <form action="course_search.php" method="GET">
        <input type="text" name="search_query" placeholder="Search.." />
        <input type="submit" value="Search" />
    </form>

    <br/><br/>

</div>

<div class="center row">
    <a class = "button" href="course_insert.php">Add new course</a>
</div>
<br>

<?php
if ($stmt->execute() && $stmt->rowCount() > 0):  ?>
<table class = "student-table">
    <thead>
    <tr>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Course Price</th>
        <th>Course Category ID</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $stmt->fetchObject()): ?>
        <tr>
            <td><?php echo $row->course_id; ?></td>
            <td><?php echo $row->course_name; ?></td>
            <td><?php echo $row->course_price; ?></td>
            <td><?php echo $row->category_id; ?></td>
            <td>
                <a href = "course_details.php?id=<?= $row->course_id ?>">Details</a>
                <a href="course_update.php?id=<?= $row->course_id ?>">Update</a>
                <a href="course_delete.php?id=<?= $row->course_id ?>" class = "delete-course" onclick="return confirm('Are you sure you want to delete this course?');">Delete</a>

            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</body>

<?php else: ?>
    <p>There's no data in courses</p>
<?php endif; ?>
<p><a href="dashboard.php">&#8592; Dashboard</a></p>
<br><br><br>
</html>
