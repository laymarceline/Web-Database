<?php

require('connection.php');

/** @var PDO $dbh Database connection */


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (
        !empty($_POST['course_name']) &&
        is_string($_POST['course_name']) &&
        !empty($_POST['course_price']) &&
        !empty($_POST['category_id']) &&
        $_POST['course_price'] > 0 &&
        $_POST['course_price'] < 9999999.99
    ) {

        $course_stmt = $dbh->prepare("INSERT INTO `course` (`course_name`, `course_price`, `category_id`) VALUES (:course_name, :course_price, :category_id)");
        if (!$course_stmt->execute([
            'course_name' => $_POST['course_name'],
            'course_price' => $_POST['course_price'],
            'category_id' => $_POST['category_id']
        ])) {
            $dbh->rollback();  // In case of error, rollback everything
            header("Location: course_insert.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('The new course cannot be added. Please try again!'));
            exit();
        }

        $insertedCourseId = $dbh->lastInsertId();

        var_dump($_FILES);
        var_dump($_POST);

        if ($_FILES['image']['error'] != 4) {
            if ($_FILES['image']['error'] != 0) {
                $dbh->rollback();
                //header("Location: course_insert.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode("File '" . $_FILES['image']['name'] . "' did not upload because: " . $phpFileUploadErrors[$_FILES['image']['error']]));
                exit();
            }

            // Check if any of the files is in wrong MIME type
            if (!empty($_FILES['image']['type']) && !in_array($_FILES['image']['type'], $allowedMIME)) {
                $dbh->rollback();  // In case of error, rollback everything
                header("Location: course_insert.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode("The type of file '" . $_FILES['image']['name'] . "' (" . $_FILES['image']['type'] . ") is not allowed"));
                exit();
            }

            // Insert new course image to course_images table
            $image_stmt = $dbh->prepare("INSERT INTO `course_image`(`course_image_id`, `course_id`, `file_path`) VALUES (:course_image_id, :course_id, :file_path)");
            $file_path = 'course_' . $insertedCourseId . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            if ($image_stmt->execute([
                'course_image_id' => $insertedCourseId,
                'course_id' => $insertedCourseId,
                'file_path' => $file_path
            ])) {
                // Finally, move images to its final place
                if (!move_uploaded_file($_FILES['image']['tmp_name'], "course_images" . DIRECTORY_SEPARATOR . $file_path)) {
                    $dbh->rollback();  // In case of error, rollback everything
                    header("Location: course_insert.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('Failed to save image files to the filesystem'));
                    exit();
                }
            } else {
                $dbh->rollback();  // In case of error, rollback everything
                header("Location: course_insert.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('The new course cannot be added. Please try again!'));
                exit();
            }
        }

        header("Location: courses.php");
    } else {
        header("Location: course_insert.php?" . $_SERVER['QUERY_STRING'] . "&error=" . urlencode('Make sure the form is valid before send!'));
    }
    exit();
}

?>
<!DOCTYPE html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Little Dreamer's Music School - Course Insert Page</title>
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
<br>
<h1>Add a new course</h1>
<div class="center">
    <?php if (!empty($_GET['error'])): ?>
        <p class="error"><?= $_GET['error'] ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <div class="row">
            <label for="course_name">Course Name</label>
            <input type="text" id="name" name="course_name" maxlength="64" required/>
        </div><br>
        <div class="row">
            <label for="course_price">Course Price</label>
            <input type="number" id="price" name="course_price" min="0" max="9999999.99" step="0.01" required/>
        </div><br>
        <div class="row">
            <label for="category_id">Category ID</label>
            <input type="number" id="category_id" name="category_id" min="0" max="9999999.99" step="0.01" required/>
        </div><br>
        <div class="row">
            <label for="image">Upload Image</label>
            <input type="file" id="image" name="image" onchange="image_checker(event)"/>
        </div><br>
        <div class="row center">
            <input type="submit" value="Add"/>
        </div><br>
    </form>
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