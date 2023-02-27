<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */


$query = "DELETE FROM `student` WHERE `student_id` = ?";
$stmt = $dbh->prepare($query);

if ($stmt->execute([$_GET['id']])):
    header("Location: students.php");
    die();
else: ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">

        <title>Delete Student #<?= $_GET['id'] ?></title>

    </head>
    <body>
    <h1>Delete student #<?= $_GET['id'] ?></h1>
    <div class="center">
        <?= friendlyError($stmt->errorInfo()[2]); ?>
        <div class="center row">
            <button onclick="window.history.back()">Back to previous page</button>
        </div>
    </div>

    </body>
    </html>
<?php endif;?>