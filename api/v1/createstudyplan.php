<?php

include_once "../../includes/api_includes.php";


create_teaching_plan();

function create_teaching_plan()
{
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    error_log("create_teaching_plan: " . $json_data);

    $grade = $data['grade'];
    $curriculum = $data['curriculum'];
    $subject = $data['subject'];
    $chapter = $data['chapter'];

    $documentData = db_get_document_by_chapters($grade, $curriculum, $subject, $chapter);
    if (!$documentData) {
        $response = array(
            "status" => "error",
        );
        api_write_error_and_exit($response, 401);
    }

    $documentId = $documentData['document'];
    $document = db_get_document($documentId);
    if (!$document) {
        $response = array(
            "status" => "error",
        );
        api_write_error_and_exit($response, 401);
    }

    $fileName = $document['name'];
    $fileType = $document['type'];
    $fileSize = $document['size'];
    $content = $document['content'];

    $txt = pdf2text($content);
    $words = explode(" ", $txt);
    $wordCount = count($words);

    // convert into array of strings of $txt if the wordcount is more than 4097
    if ($wordCount > 4097) {
        $txt = str_split($txt, 4097)[0];
    }

    // $txt = "the Los Angeles Dodgers won the World Series in 2020.";

    $prompts = get_all_promts();
    include_once "../../includes/generate_open_api.php";

    $additional_params = [];
    foreach ($prompts as $prompt_key => $prompt) {
        if($prompt_key == "lessson_plan") {
            if($subject == "Science") {
                $prompt = "Create a detailed lesson plan for a 45-minute class on for 6th-grade students. The lesson should follow The 5E Instructional Model (Engage, Explore, Explain, Elaborate, Evaluate).";
            } else {
                $prompt = "Create a detailed lesson plan for a 45-minute class on for 6th-grade students. The lesson should follow Bruner's Theory of 'Discovery Learning'.";
            }
        }
        $messages = [
            [
                "role" => "system",
                "content" => $txt,
            ],
            [
                "role" => "user",
                "content" => $prompt,
            ]
        ];
        $openAPI = new GenerateOpenApiFrameWork();
        $openAPI->initilizeOpenAPI($messages, $additional_params);
        $response = $openAPI->generateOpenAPI();

        $responses[$prompt_key] = $response;
        // break;
    }

    $response = array(
        "status" => "success",
        "data" => $responses
    );
    api_write_success_and_exit($response, 200);
}


function test_create_teaching_plan()
{
    $json_data = [
        "grade" => "1",
        "curriculum" => "CBSE",
        "subject" => "Maths",
        "chapter" => "1"
    ];
}

function get_all_promts()
{
    $input = "..\..\promts.json";
    $prompts = json_decode(file_get_contents($input), true);

    return $prompts;
}
