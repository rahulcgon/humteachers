<?php
if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
    $grade = $_POST['grade'];
    $curriculum = $_POST['curriculum'];
    $subject = $_POST['subject'];
    $chapter = $_POST['chapter'];

    $is_exist_documents = db_get_document_by_chapters($grade, $curriculum, $subject, $chapter);
    if ($is_exist_documents) {
        print "Document already exists";
        return;
    }

    $fileName = $_FILES['userfile']['name'];
    $tmpName  = $_FILES['userfile']['tmp_name'];
    $fileSize = $_FILES['userfile']['size'];
    $fileType = $_FILES['userfile']['type'];

    $fp      = fopen($tmpName, 'r');
    $content = fread($fp, filesize($tmpName));
    $content = addslashes($content);
    fclose($fp);

    // convert pdf to text
    // $text = pdf2text($tmpName);
    // logMessage($text);

    $file_id = db_push_file($fileName, $fileSize, $fileType, $content);

    $result = db_push_document($grade, $curriculum, $subject, $chapter, $file_id);
}
