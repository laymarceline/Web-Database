<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Little Dreamer's Music School - Course Update</title>

    <meta name="description" content="2022 S2 Assignment">
    <meta name="author" content="FIT2104 Web Database Interface">

    <link rel="stylesheet" href="styles.css">
</head>
<body>
<ul>
    <a href = "index.html"><img width="240" height="70" src = "images/a2_logo.png"></a>
    <li style="float:right"><a href="images.php">Course Images</a></li>
    <li style="float:right"><a href="tailored_classes.php">Tailored Classes</a></li>
    <li style="float:right"><a href="category.php">Category</a></li>
    <li style="float:right"><a class="active" href="courses.php">Courses</a></li>
    <li style="float:right"><a href="students.php">Students</a></li>
</ul>
<p><a href="courses.php">&#8592; Courses</a></p>
<br>
<h1>Update course #<?= $_GET['id'] ?></h1>
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

        $allowedMIME = array(
            'image/jpeg',
            'image/png',
            'image/gif'
        );

        foreach ($_POST as $fieldName => $fieldValue) {
            if (empty($fieldValue)) {
                echo friendlyError("'$fieldName' field is empty. Please fix the issue try again. ");
                echo '<div class="center row"><button onclick="window.history.back()">Back to previous page</button></div>';
                die();
            }
        }
        $query = "UPDATE `course` SET `course_name` = :course_name,`course_price` = :course_price,`category_id` = :category_id WHERE `course_id` = :id";
        $stmt = $dbh->prepare($query);

        $parameters = [
            'course_name' => $_POST['course_name'],
            'course_price' => $_POST['course_price'],
            'category_id' => $_POST['category_id'],
            'id' => $_GET['id']
        ];

        if ($stmt->execute($parameters)) {
            header("Location: courses.php");
        } else {
            echo friendlyError($stmt->errorInfo()[2]);
            echo '<div class="center row"><button onclick="window.history.back()">Back to previous page</button></div>';
            die();
        }

        if ($_FILES['image']['error'] != 4) {
            if ($_FILES['image']['error'] != 0) {
                $dbh->rollback();
                header("Location: course_update.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode("File '" . $_FILES['image']['name'] . "' did not upload because: " . $phpFileUploadErrors[$_FILES['image']['error']]));
                exit();
            }

            // Check if any of the files is in wrong MIME type
            if (!empty($_FILES['image']['type']) && !in_array($_FILES['image']['type'], $allowedMIME)) {
                $dbh->rollback();  // In case of error, rollback everything
                header("Location: course_update.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode("The type of file '" . $_FILES['image']['name'] . "' (" . $_FILES['image']['type'] . ") is not allowed"));
                exit();
            }

            // Delete image from course_images folder
            $image_path_stmt = $dbh->prepare("SELECT * FROM `course_image` WHERE `course_image_id` = :id");
            if($image_path_stmt->execute([
                'id' => $_GET['id']
            ])){
                $image_path = $image_path_stmt->fetchObject()->file_path;
                unlink("course_images/".$image_path);
                // Delete record
                $image_stmt = $dbh->prepare("DELETE FROM `course_image` WHERE `course_image_id` = :id");
                if($image_stmt->execute([
                    'id' => $_GET['id']
                ]));
            };

            // Insert new course image to course_images table
            $image_stmt = $dbh->prepare("INSERT INTO `course_image`(`course_image_id`, `course_id`, `file_path`) VALUES (:course_image_id, :course_id, :file_path)");
            $file_path = uniqid('course_' . $_GET['id'] . '_', true) . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if ($image_stmt->execute([
                'course_image_id' => $_GET['id'],
                'course_id' => $_GET['id'],
                'file_path' => $file_path
            ])) {
                // Finally, move images to its final place
                if (!move_uploaded_file($_FILES['image']['tmp_name'], "course_images" . DIRECTORY_SEPARATOR . $file_path)) {
                    $dbh->rollback();  // In case of error, rollback everything
                    header("Location: course_update.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('Failed to save image files to the filesystem'));
                    exit();
                }
                header("Location: courses.php");
            } else {
                $dbh->rollback();  // In case of error, rollback everything
                header("Location: course_update.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('The updated course cannot be added. Please try again!'));
                exit();
            }
            header("Location: courses.php");
        }

    } else {
        $query = "SELECT * FROM `course` WHERE `course_id` = ?";
        $stmt = $dbh->prepare($query);
        if ($stmt->execute([$_GET['id']])) {
            if ($stmt->rowCount() > 0) {
                $record = $stmt->fetchObject(); ?>
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <label for="course_id">ID</label>
                        <input type="number" id="course_id" value="<?= $record->course_id ?>" disabled/>
                    </div><br>
                    <div class="row">
                        <label for="course_name">Course Name</label>
                        <input type="text" id="course_name" name="course_name" value="<?= $record->course_name ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="course_price">Course Price</label>
                        <input type="number" min="0.00" max="10000.00" step="0.01" id="course_price" name="course_price" value="<?= $record->course_price ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="category_id">Category ID</label>
                        <input type="category_id" id="category_id" name="category_id" value="<?= $record->category_id ?>"/>
                    </div><br>
                    <div class="row">
                        <label for="image">Upload Image</label>
                        <input type="file" id="image" name="image" onchange="image_checker(event)"/>
                    </div><br>
                    <div class="row center">
                        <input type="submit" value="Update"/>
                    </div><br>
                </form>
            <?php } else {
                header("Location: courses.php");
            }
        } else {
            die(friendlyError($stmt->errorInfo()[2]));
        }
    }
    ?>

</div>
<script>
    function image_checker(event) {
        let file_is_valid = true;

        let file = event.target.files[0];

        // Test file size
        let size = file.size;
        if (size > 2000000) {
            file_is_valid = false;
            event.target.setCustomValidity("File is too big! The size must be smaller than 2MB");
        }
        let filetype = file.type;
        if (!(['image/jpeg', 'image/png', 'image/gif'].includes(filetype))) {
            file_is_valid = false;
            event.target.setCustomValidity("File must be JPEG, PNG or GIF formatted images");
        }

        if (file_is_valid) {
            event.target.setCustomValidity("");
        }
    }
</script>
</body>
</html>
