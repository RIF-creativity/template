<?php
require_once __DIR__ . '/vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf();

function pdf($conten){
    global $mpdf;
    $mpdf->WriteHTML($conten);
    $mpdf->Output();
}
