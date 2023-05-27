<?php
// create a schema for the database for grade, curriculum, subjects, chapters, Document file

global $CONN;
$CONN = initiate_database();

function create_database() {
    $sql = "CREATE DATABASE IF NOT EXISTS `teacher_ai` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;";

    // create a schema for the database for grade, curriculum, subjects, chapters, Document file
    $sql = "create table if not exists `chapter_details` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `grade` varchar(255) NOT NULL,
        `curriculum` varchar(255) NOT NULL,
        `subject` varchar(255) NOT NULL,
        `chapter` varchar(255) NOT NULL,
        `document` varchar(255) NOT NULL,
        PRIMARY KEY (`id`)
    );";


    // storing the file in the database
    $sql = "create table if not exists `chapter_document` (
        id int(11) NOT NULL AUTO_INCREMENT,
        name VARCHAR(30) NOT NULL,
        type VARCHAR(30) NOT NULL,
        size INT NOT NULL,
        content MEDIUMBLOB NOT NULL,
        PRIMARY KEY(id)
    );";
}

function initiate_database() {
    // initiate database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "teacher_ai";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    return $conn;
}

function db_query($sql) {
    global $CONN;
    $result = mysqli_query($CONN, $sql);
    return $result;
}

function db_fetch_array($result) {
    if ($result) {
        $array = mysqli_fetch_array($result, MYSQLI_ASSOC);
        return isset($array) ? $array : FALSE;
    }
}