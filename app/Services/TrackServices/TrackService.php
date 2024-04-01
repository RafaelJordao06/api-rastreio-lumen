<?php

namespace App\Services\TrackServices;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class TrackService
{
    protected $client;
    protected $userEmail;
    protected $apiToken;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://api.linketrack.com/']);
        $this->userEmail = env('USER_EMAIL');
        $this->apiToken = env('API_TOKEN');
    }

    public function rastrearEncomenda($trackingCode)
    {
        try {
            $response = $this->client->get("track/json", [
                'query' => [
                    'user' => $this->userEmail,
                    'token' => $this->apiToken,
                    'codigo' => str_replace(' ', '', urldecode($trackingCode)),
                ]
            ]);

            // A resposta já vem em formato JSON, então só precisamos converter para array associativo.
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $exception) {
            // Lidar com erros da requisição
            error_log("Erro na requisição à API de rastreamento: " . $exception->getMessage());
            throw $exception;
        }
    }
}
 