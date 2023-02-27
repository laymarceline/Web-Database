


<?php

require_once('connection.php');
/** @var PDO $dbh Database connection */

$stmt = $dbh->prepare("SELECT * FROM `student` WHERE `subscribe` = 1;");
if ($stmt->execute() && $stmt->rowCount() > 0){
    while ($row = $stmt->fetchObject()){
            $addresses[] = $row->email;
    }
    $to = implode(", ", $addresses);
    $subject = "Test mail";
    $message = "Hello! This is a simple email message.";
    $from = "dane@admin.com";
    $headers = "From:" . $from;

    mail($to, $subject, $message, $headers);
}

?>