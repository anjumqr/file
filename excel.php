<?php
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = IOFactory::load('hello_world.xlsx'); // existing file
$writer = IOFactory::createWriter($spreadsheet, 'Html');
$writer->save('php://output');
