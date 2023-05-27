<?php

include_once "vendor\autoload.php";

function pdf2text($filename) {
    // Read the file into a string
    $pdf = file_get_contents($filename);
    // Load the file
    $parser = new \Smalot\PdfParser\Parser();
    $pdf    = $parser->parseFile($filename);
    // Retrieve all pages from the pdf file.
    $pages  = $pdf->getPages();
    // Loop over each page to extract text.
    $text = "";
    foreach ($pages as $page) {
        $text .= $page->getText();
    }
    return $text;
}


function logMessage($text) {
    print $text . "\n";
}

