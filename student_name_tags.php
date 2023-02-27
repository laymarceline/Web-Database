<?php
include('connection.php');
/** @var PDO $dbh Database connection */
require_once __DIR__ . '/vendor/autoload.php';

$result = $dbh->prepare("SELECT CONCAT(`first_name`, ' ', `surname`) FROM `student`;");
$result->execute();

use Mpdf\Mpdf;

$mpdf = new Mpdf();
$mpdf->AddPage();
$mpdf->SetFont('Arial','B',12);

foreach($result as $row) {
    $mpdf->Ln();
    foreach($row as $column)
        $mpdf->Cell(90,12,$column,1);
}
$mpdf->Output();
?>
