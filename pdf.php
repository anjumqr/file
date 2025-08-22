<?php
$imagick = new Imagick();
$imagick->setResolution(150, 150);
$imagick->readImage('File/sample.pdf[0]'); // page 1
$imagick->setImageFormat('png');
header("Content-Type: image/png");
echo $imagick;
