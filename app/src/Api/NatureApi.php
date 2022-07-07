<?php

namespace Source\Api;

use GuzzleHttp\Exception\GuzzleException;

class NatureApi extends SupeAuthApi
{
    /**
     * @param array $data
     * @return void
     */
    public function activeBySecretariat(array $data): void
    {
        try {
            $secretary = preg_replace('/\D/', '', ($data['secretary'] ?? null));

            $response = $this->client->get("natureza/secretaria/{$secretary}", [
                'headers' => ['Authorization' => "Bearer {$this->getToken()}"],
                'json' => []
            ]);

            echo $response->getBody();
        } catch (GuzzleException $e) {
            $this->unexpected();
        }
    }
}
