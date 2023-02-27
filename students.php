<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

// Read all courses
$stmt = $dbh->prepare("SELECT * FROM `student`;");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School - Students Page</title>

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
<p><a href="dashboard.php">&#8592; Dashboard</a></p>
<br>
<div>
    <?php
    if ($stmt->execute() && $stmt->rowCount() > 0): //execute if data exists ?>
    <center><h1>Students</h1></center>
        <a class ="button"a href = "student_add.php">Add Student</a>
        <a class ="button"a href = "student_subscribers.php">List Subscribers</a>
        <a class ="button"a href = "student_name_tags.php">Generate Name Tags</a>
        <br> <br>
        <table class = "student-table">
            <thead>
            <tr>
                <th>Select</th>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Subscribe</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetchObject()): ?>
                <tr>
                    <td><input type="checkbox" name="student_ids[]" class="student-delete" value="<?php echo $row->student_id; ?>"/></td>
                    <td><?= $row->student_id; ?></td>
                    <td><?= $row->first_name, " ", $row->surname; ?></td>
                    <td><?= $row->phone; ?></td>
                    <td><?= $row->dob; ?></td>
                    <td><a href="mailto:<?= $row->email ?>" ><?= $row->email ?></a></td>
                    <td><?php if($row->subscribe == 0){
                            echo "No";
                        } else{
                            echo "Yes";} ?>
                    </td>
                    <td>
                        <a href = "student_details.php?id=<?= $row->student_id ?>">Details</a>
                        <a href = "student_update.php?id=<?= $row->student_id ?>">Update</a>
                        <a href="student_delete.php?id=<?= $row->student_id ?>" class = "delete-student" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
            <p>There's no data in students</p>
        <?php endif; ?>
        <br>
</div>
<p><a href="dashboard.php">&#8592; Dashboard</a></p>
</body>
</html>