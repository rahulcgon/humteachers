<?php
function db_push_document($grade, $curriculum, $subject, $chapter, $file_id) {
    $sql = "INSERT INTO `chapter_details` (`grade`, `curriculum`, `subject`, `chapter`, `document`) VALUES ('$grade', '$curriculum', '$subject', '$chapter', '$file_id');";
    $result = db_query($sql);
    return $result;
}

function db_push_file($fileName, $fileSize, $fileType, $content) {
    $sql = "INSERT INTO `chapter_document` (`name`, `type`, `size`, `content`) VALUES ('$fileName', '$fileType', '$fileSize', '$content');";
    $result = db_query($sql);

    $sql = "SELECT `id` FROM `chapter_document` WHERE `name` = '$fileName';";
    $result = db_query($sql);
    $row = db_fetch_array($result);
    return $row['id'];
}

function db_get_document($id) {
    $sql = "SELECT * FROM `chapter_document` WHERE `id` = $id;";
    $result = db_query($sql);
    return $result;
}


function db_get_all_documents() {
    $sql = "SELECT * FROM `chapter_details`;";
    $result = db_query($sql);
    return $result;
}
