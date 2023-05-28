<?php

class GenerateOpenApiFrameWork
{
    public $openApiPostPayload = [];

    const OPEN_API_URL = "https://api.openai.com/v1/chat/completions";
    const OPEN_API_AUTHORIZATION = "Bearer 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";
    const OPEN_API_CURLOPT_HTTPHEADER = [
        'Content-Type: application/json',
        'Accept: application/json',
        "Authorization: " . self::OPEN_API_AUTHORIZATION . ""
    ];

    const OPEN_API_MODEL = "gpt-3.5-turbo";


    public function initilizeOpenAPI($messages, $additionalParameters = [])
    {
        $this->initOpenAPIArray();

        $this->openApiPostPayload["messages"] = $messages;

        foreach ($additionalParameters as $key => $value) {
            $this->openApiPostPayload[$key] = $value;
        }
    }

    private function initOpenAPIArray()
    {
        $this->openApiPostPayload = array(
            "model" => self::OPEN_API_MODEL,
            "messages" => '',
            "temperature" => 0,
            "top_p" => 0.5,
            "n" => 1,
            "stream" => false,
            "max_tokens" => 10,
            "presence_penalty" => 0,
            "frequency_penalty" => 0
        );
    }

    public function generateOpenAPI()
    {
        // $response = $this->makeOpenAPIPostCall1();
        $response = $this->makeOpenAPIPostCall();
        $response = json_decode($response);
        return $response;
    }

    private function makeOpenAPIPostCall1()
    {
        $curl = curl_init();

        $options =  array(
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "model": "gpt-3.5-turbo",
                "messages": [
                    {
                        "role": "user",
                        "content": "Who won the world series in 2020?"
                    }
                ],
                "temperature": 1,
                "top_p": 1,
                "n": 1,
                "stream": false,
                "max_tokens": 10,
                "presence_penalty": 0,
                "frequency_penalty": 0
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer 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'
            ),
        );

        // print json_encode($options);
        // print "esadfafsaasdasdasdasdasdas";

        // return;

        curl_setopt_array($curl, $options);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }


    private function makeOpenAPIPostCall()
    {
        // Initialize cURL session
        $curl = curl_init();

        $openApiPostPayload = json_encode($this->openApiPostPayload);

        $options = array(
            CURLOPT_URL => self::OPEN_API_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $openApiPostPayload,
            CURLOPT_HTTPHEADER => self::OPEN_API_CURLOPT_HTTPHEADER,
        );

        // print json_encode($options);
        // print "esadfafsaasdasdasdasdasdas";
        // return;

        // Set cURL options
        curl_setopt_array($curl, $options);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        // Execute the cURL request
        $response = curl_exec($curl);

        // Close the cURL session
        curl_close($curl);

        return $response;
    }
}
