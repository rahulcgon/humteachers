<?php

include_once "vendor\autoload.php";

function pdf2text($pdfBlob) {
    $filename = tempnam(sys_get_temp_dir(), 'pdf');
    file_put_contents($filename, $pdfBlob);

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

function api_write_error_and_exit($data = [], $status_code = 401) {
    $return_data = [];
    if(!is_array($data)) {
        $return_data['error'] = $data;
    } else {
        $return_data = $data;
    }
    header('Error with 401', TRUE, $status_code);
    $return_data['status_code'] = $status_code;

    print json_encode($return_data);
    exit();
}

function api_write_success_and_exit($data = [], $status_code = 200) {
    $return_data = [];

    $return_data = $data;
    header('Success with 200', TRUE, $status_code);
    $return_data['status_code'] = $status_code;

    print json_encode($return_data);
    exit();
}