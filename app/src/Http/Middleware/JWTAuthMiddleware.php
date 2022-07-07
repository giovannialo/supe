<?php

namespace Source\Http\Middleware;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Source\Api\ApiInterface;

class JWTAuthMiddleware implements ApiInterface
{
    /**
     * @return bool
     */
    public function handle(): bool
    {
        $headers = getallheaders();

        $jwt = (isset($headers['Authorization']) ? str_replace('Bearer ', '', $headers['Authorization']) : '');

        try {
            JWT::decode($jwt, new Key(CONF_JWT_KEY, CONF_JWT_ALGORITHM));
            return true;
        } catch (Exception $e) {
            http_response_code(self::FORBIDDEN);
            echo json_encode(['erro' => true, 'erros' => [13003 => errorByCode(13003)]]);
            exit;
        }
    }
}