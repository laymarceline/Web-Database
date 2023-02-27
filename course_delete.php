<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

$image_path_stmt = $dbh->prepare("SELECT * FROM `course_image` WHERE `course_image_id` = :id");

// Delete the course image from course_images
if($image_path_stmt->execute([
    'id' => $_GET['id']
])){
    $image_path = $image_path_stmt->fetchObject()->file_path;
    unlink("course_images/".$image_path);
    $course_stmt = $dbh->prepare("DELETE FROM `course_image` WHERE `course_id` = :id");
    $course_stmt->execute([
        'id' => $_GET['id']
    ]);
};

// Delete Course Record
$query = "DELETE FROM `course` WHERE `course_id` = ?";
$stmt = $dbh->prepare($query);

if ($stmt->execute([$_GET['id']])):
    header("Location: courses.php");
    die();
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Delete course #<?= $_GET['id'] ?></title>

    </head>
    <body>
    <h1>Delete course #<?= $_GET['id'] ?></h1>
    <div class="center">
        <?= friendlyError($stmt->errorInfo()[2]); ?>
        <div class="center row">
            <button onclick="window.history.back()">Back to previous page</button>
        </div>
    </div>

    </body>
    </html>
<?php endif;?>