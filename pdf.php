<?php
require 'vendor/autoload.php';

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 14);
$pdf->Write(0, 'Hello PDF World!');
$pdf->Output('example.pdf', 'I'); // I = inline view in browser
