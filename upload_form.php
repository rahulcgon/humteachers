<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>
    <form method="post" enctype="multipart/form-data">
        <div class="form-check">
            <label for="grade">Grade:</label>
            <input type="text" id="grade" name="grade" required value="<?php print generateRandomValue("grades"); ?>">
        </div>

        <div class="form-check">
            <label for="curriculum">Curriculum:</label>
            <input type="text" id="curriculum" name="curriculum" required value="<?php print generateRandomValue("curriculum"); ?>">
        </div>

        <div class="form-check">
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required value="<?php print generateRandomValue("subject"); ?>">
        </div>

        <div class="form-check">
            <label for="chapter">Chapter:</label>
            <input type="text" id="chapter" name="chapter" required value="<?php print generateRandomValue("chapter"); ?>">
        </div>

        <div class="form-check">
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input name="userfile" type="file" id="userfile">
        </div>
        <br><br />
        <div class="form-check">
            <input name="upload" type="submit" class="box" id="upload" value=" Upload ">
        </div>
    </form>
</body>

</html>