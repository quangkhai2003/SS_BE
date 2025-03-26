<?php
namespace App\Services;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FApiService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(); // Khởi tạo HTTP client
    }

    public function processAiRequest(UploadedFile $file)
    {
        // Gọi API bên ngoài (giả sử là FastAPI)
        $response = $this->client->request('POST', 'http://127.0.0.1:7000/predict', [
            'multipart' => [
                [
                    'name' => 'file', // Tên trường giống Postman
                    'contents' => fopen($file->getRealPath(), 'r'), // Nội dung file
                    'filename' => $file->getClientOriginalName(),
                ]
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }
}