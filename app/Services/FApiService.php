<?php
namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FApiService
{
    protected $client;
    protected $baseUrl = 'http://127.0.0.1:7000'; // Định nghĩa base URL một lần duy nhất

    public function __construct()
    {
        $this->client = new Client(); // Khởi tạo HTTP client
    }

    public function processAiRequest(UploadedFile $file)
    {
        // Gọi API với base URL + endpoint
        $response = $this->client->request('POST', $this->baseUrl . '/predict', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName(),
                ]
            ]
        ]);
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function pronunciation($sample_sentence, UploadedFile $file)
    {
        try {
            $response = $this->client->request('POST', $this->baseUrl . '/pronunciation', [
                'multipart' => [ 
                    [
                        'name'     => 'sample_sentence',
                        'contents' => $sample_sentence
                    ],
                    [
                        'name'     => 'file',
                        'contents' => fopen($file->getRealPath(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                        'headers'  => [
                            'Content-Type' => $file->getClientMimeType()
                        ]
                    ]
                ]
            ]);
    
            return json_decode($response->getBody()->getContents(), true);
    
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            return [
                'error' => json_decode($response->getBody()->getContents(), true),
                'status' => $response->getStatusCode()
            ];
        }
    }

    public function audio($word, $voice)
    {
        $response = $this->client->request('POST', $this->baseUrl . '/audio', [
            'json' => [
                'word' => $word,
                'voice' => $voice
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    public function generate($word)
    {
        $response = $this->client->request('POST', $this->baseUrl . '/generate', [
            'json' => [
                'word' => $word
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
}