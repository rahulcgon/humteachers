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

    convert_json($return_data);
    exit();
}

function api_write_success_and_exit($data = [], $status_code = 200) {
    $return_data = [];

    $return_data = $data;
    header('Success with 200', TRUE, $status_code);
    $return_data['status_code'] = $status_code;

    print convert_json($return_data);
    exit();
}

function convert_json($var) {
    switch (gettype($var)) {
        case 'boolean':
            return $var ? 'true' : 'false'; // Lowercase necessary!
        case 'integer':
        case 'double':
            return $var;
        case 'resource':
        case 'string':
            //Tribyte change. Fix to get jquery version 1.5 working with drupal 6.
            return str_replace(array("<", ">", "&"), array('\u003c', '\u003e', '\u0026'), json_encode($var));
        case 'array':
            // Arrays in JSON can't be associative. If the array is empty or if it
            // has sequential whole number keys starting with 0, it's not associative
            // so we can go ahead and convert it as an array.
            if (empty($var) || array_keys($var) === range(0, sizeof($var) - 1)) {
                $output = array();
                foreach ($var as $v) {
                    $output[] = convert_json($v);
                }
                return '[ ' . implode(', ', $output) . ' ]';
            }
        // Otherwise, fall through to convert the array as an object.
        case 'object':
            $output = array();
            foreach ($var as $k => $v) {
                $output[] = convert_json(strval($k)) . ': ' . convert_json($v);
            }
            return '{ ' . implode(', ', $output) . ' }';
        default:
            return 'null';
    }
}