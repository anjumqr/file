<?php
require '../vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;

// Load Word file
$phpWord = IOFactory::load('sample.docx');

// Save as HTML and show in browser
$xmlWriter = IOFactory::createWriter($phpWord, 'HTML');
$xmlWriter->save('php://output');
