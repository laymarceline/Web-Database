<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

// Read all courses
$stmt = $dbh->prepare("SELECT * FROM `student` WHERE `subscribe` = 1;");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Little Dreamer's Music School - List Subscribers</title>

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
<br>
<div>
    <?php
    $subscribers = "";
    if ($stmt->execute() && $stmt->rowCount() > 0): //execute if data exists ?>
    <?php $count = 0;?>
        <center><h2>Subscribers</h2></center>
        <br> <br>
        <table class = "student-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Subscribe</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $stmt->fetchObject()): ?>
                <tr>
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
                    <?php if($count < $stmt->rowCount()){
                        if ($subscribers != ""){
                            $subscribers = $subscribers . ';' . $row->email;
                        } else{
                            $subscribers = $row->email;
                        }
                        $count = $count + 1;
                    } ?>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>There's no data in students</p>
    <?php endif; ?>
    <br>
    <h4> List of Subscribers </h4>
    <?php echo $subscribers ?> <br><br>
    <p><input type="text" value= <?php echo $subscribers?> id="myInput"></p>
    <p><button class = "button" onclick="myFunction()">Copy To Clipboard</button></p>
</div>
</body>
<script>
    function myFunction() {
        // Get the text field
        var copyText = document.getElementById("myInput");

        // Select the text field
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices

        // Copy the text inside the text field
        navigator.clipboard.writeText(copyText.value);

        // Alert the copied text
        alert("Copied the text: " + copyText.value);
    }
</script>
</html>