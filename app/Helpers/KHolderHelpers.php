<?php

namespace App\Helpers;

use GuzzleHttp\Client;

class KHolderHelpers
{
    public $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendLoginRequest($credentials)
    {
        $options = [
            "body" => json_encode([
                "username" => $credentials["email"],
                "password" => $credentials["password"]
            ]),
            "headers" => [
                "Content-Type" => "application/json"
            ],
            "http_errors" => false
        ];
        $response = $this->client->post(env('KHOLDER_URL_LOCAL').'/api/telework-login', $options);
        return $response->getBody();
    }

    public function getUserInformation($token)
    {
        $options = [
            "body" => json_encode([
                "access_token" => $token,
            ]),
            "headers" => [
                "Content-Type" => "application/json"
            ],
            "http_errors" => false
        ];
        $response = $this->client->post(env('KHOLDER_URL_LOCAL').'/api/telework-login', $options);
        return $response->getBody();
    }
}
