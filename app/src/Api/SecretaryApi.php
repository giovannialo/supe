<?php

namespace Source\Api;

use GuzzleHttp\Exception\GuzzleException;

class SecretaryApi extends SupeAuthApi
{
    /**
     * @return void
     */
    public function index(): void
    {
        try {
            $response = $this->client->get('secretaria', [
                'headers' => ['Authorization' => "Bearer {$this->getToken()}"],
                'json' => []
            ]);

            echo $response->getBody();
        } catch (GuzzleException $e) {
            $this->unexpected();
        }
    }
}
