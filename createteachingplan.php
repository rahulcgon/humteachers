<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>
<!DOCTYPE html>
<html>

<head>
    <title>Teaching Plan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="scripts/studyplan.js"></script>
    <link rel="stylesheet" href="styles/studyplan.css" />

</head>

<?php
include "included_files.php";

$grade = ["Grade 6"];
$curriculum = ["NCERT"];
$subject = ["Mathematics", "Science", "Social Science"];
$subject = ["", "Maths", "Science"];
$chapter = ["","Chapter 3 - Playing with Numbers", "Chapter 4 - Getting to know Plants"];

$classes =  [1, 2, 3, 4, 5, 6, 7, 8, 9];


?>

<body>
    <div class="teaching_plan_center">
        <h1>Creating Teaching Plan</h1>

        <div class="form-group center">
            <form action="" method="GET">
                <div id="grade_group" class="form-group">
                    <label for="grade">Grades:</label>
                    <select class="form-select" id="grade" aria-label="Default select example">
                        <?php foreach ($grade as $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div id="curriculum_group" class="form-group">
                    <label for="curriculum">Curriculums:</label>
                    <select class="form-select" id="curriculum" aria-label="Default select example">
                        <?php foreach ($curriculum as $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div id="subject_group" class="form-group">
                    <label for="subject">Subjects:</label>
                    <select class="form-select" id="subject" aria-label="Default select example">
                        <?php foreach ($subject as $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div id="chapter_group" class="form-group">
                    <label for="chapter">Chapters:</label>
                    <select class="form-select" id="chapter" aria-label="Default select example">
                        <?php foreach ($chapter as $value) { ?>
                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                        <?php } ?>
                    </select>
                </div>


                <br />
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>

    <br/>
    <br/>


    <!-- hide the loader -->
    <div id="loader">
    </div>


</body>

</html>