<?php

include_once "../../includes/api_includes.php";



get_all_studyplan();

function get_all_studyplan() {
    $all_documents = db_get_all_documents();

    $response = array();
    $response['status'] = 'success';
    $response['message'] = 'All documents';
    $response['data'] = $all_documents;
    api_write_success_and_exit($response, 200);
}