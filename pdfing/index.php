<?php

ini_set("disable_functions", "");
ini_set("display_errors", 1);

include __DIR__.'/../vendor/autoload.php';



$pdf = new Gufy\PdfToHtml\Pdf(__DIR__.'/document.pdf');

$html = $pdf->html(1);

echo $html;
