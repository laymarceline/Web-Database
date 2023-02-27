<?php
require_once('connection.php');
/** @var PDO $dbh Database connection */

// It's a good idea to first check if the required fields are valid
if (isset($_POST['course_image_ids']) && is_array($_POST['course_image_ids'])) {
    // MySQL supports condition in a range in the format of a, b, c, d
    // Thus we'll need to generate the same number of ? placeholders depend on how many items in the form
    $stmt_placeholders = implode(', ', array_fill(0, count($_POST['course_image_ids']), '?'));
    $delete_course_stmt = $dbh->prepare("DELETE FROM `course_image` WHERE `course_image_id` IN ($stmt_placeholders)");

    $delete_course_stmt->execute($_POST['course_image_ids']);
}

// Finally, send the user back to the previous location
header('Location: ' . $_SERVER['HTTP_REFERER']);