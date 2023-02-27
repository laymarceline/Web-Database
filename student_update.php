<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School - Student Update</title>

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
<h1>Update student #<?= $_GET['id'] ?></h1>
<div class="center">
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST)) {
        $phpFileUploadErrors = array(
            0 => 'There is no error, the file uploaded with success',
            1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            3 => 'The uploaded file was only partially uploaded',
            4 => 'No file was uploaded',
            6 => 'Missing a temporary folder',
            7 => 'Failed to write file to disk.',
            8 => 'A PHP extension stopped the file upload.',
        );

        $_POST['subscribe'] = (int)$_POST['subscribe'];

        foreach ($_POST as $fieldName => $fieldValue) {
            if($_POST['subscribe'] == 0){

            }
            else if (empty($fieldValue)) {
                echo friendlyError("'$fieldName' field is empty. Please fix the issue try again. ");
                echo '<div class="center row"><button onclick="window.history.back()">Back to previous page</button></div>';
                die();
            }
        }
        $query = "UPDATE `student` SET `first_name` = :first_name,`surname` = :surname, `address` = :address,`phone` = :phone, `dob` = :dob, `email` = :email, `subscribe` = :subscribe WHERE `student_id` = :id";
        $stmt = $dbh->prepare($query);

        var_dump($_POST);
        $parameters = [
            'first_name' => $_POST['first_name'],
            'surname' => $_POST['surname'],
            'address' => $_POST['address'],
            'phone' => $_POST['phone'],
            'dob' => $_POST['dob'],
            'email' => $_POST['email'],
            'subscribe' => $_POST['subscribe'],
            'id' => $_GET['id']
        ];

        if ($stmt->execute($parameters)) {
            header("Location: students.php");
        } else {
            echo friendlyError($stmt->errorInfo()[2]);
            echo '<div class="center row"><button onclick="window.history.back()">Back to previous page</button></div>';
            die();
        }

        header("Location: students.php");

    } else {
        $query = "SELECT * FROM `student` WHERE `student_id` = ?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$_GET['id']])) {
            if ($stmt->rowCount() > 0) {
                $record = $stmt->fetchObject(); ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <label for="student_id">ID</label>
                        <input type="number" id="student_id" value="<?= $record->student_id ?>" disabled/>
                    </div><br>
                    <div class="row">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" maxlength="50" value="<?= $record->first_name ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="surname">Last Name</label>
                        <input type="text" id="surname" name="surname" maxlength="20" value="<?= $record->surname ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" maxlength="100" value="<?= $record->address ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" maxlength="15" value="<?= $record->phone ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" value="<?= $record->dob ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" maxlength="80" value="<?= $record->email ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="subscribe">Subscribe</label>
                        <select name="subscribe" id="subscribe" value="<?= $record->subscribe ?>">
                            <option value= 1>Yes</option>
                            <option value= 0>No</option>
                        </select>
                    </div><br>
                    <div class="row center">
                        <input type="submit" value="Update"/>
                    </div><br>
                </form>
            <?php } else {
                header("Location: students.php");
            }
        } else {
            die(friendlyError($stmt->errorInfo()[2]));
        }
    }
    ?>
</div>
</body>
</html>