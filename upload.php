<?php
if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
    $all_documents = db_get_all_documents();
    foreach ($all_documents as $document) {
        if ($document['grade'] == $_POST['grade'] &&
            $document['curriculum'] == $_POST['curriculum'] &&
            $document['subject'] == $_POST['subject'] &&
            $document['chapter'] == $_POST['chapter']) {
            print "Document already exists";
            return;
        }
    }
    $grade = $_POST['grade'];
    $curriculum = $_POST['curriculum'];
    $subject = $_POST['subject'];
    $chapter = $_POST['chapter'];

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
