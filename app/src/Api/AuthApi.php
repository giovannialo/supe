<?php

namespace Source\Api;

use Firebase\JWT\JWT;
use LandKit\Model\Connect;
use Source\Models\UserApiModel;

class AuthApi implements ApiInterface
{
    /**
     * @return void
     */
    public function signIn(): void
    {
        $errors = [];
        $data = (json_decode(file_get_contents('php://input'), true) ?? []);

        if (!isset($data['usuario'])) {
            $errors[12009] = errorByCode(12009);
        }

        if (!isset($data['senha'])) {
            $errors[12010] = errorByCode(12010);
        }

        if (!isset($data['hash'])) {
            $errors[12011] = errorByCode(12011);
        }

        if ($errors) {
            echo json_encode(['erro' => true, 'erros' => $errors]);
            exit;
        }

        $user = (new UserApiModel())->where('nome = :n', "n={$data['usuario']}")->fetch();

        if (!$user || !password_verify($data['senha'], $user->senha)) {
            http_response_code(self::UNAUTHORIZED);
            echo json_encode(['erro' => true, 'erros' => [13001 => errorByCode(13001)]]);
            exit;
        }

        if ($data['hash'] != $user->hash) {
            http_response_code(self::UNAUTHORIZED);
            echo json_encode(['erro' => true, 'erros' => [13002 => errorByCode(13002)]]);
            exit;
        }

        $payload = [
            'nome_usuario' => strtoupper($user->nome),
            'exp' => strtotime('+24 hours')
        ];

        echo json_encode(['token' => JWT::encode($payload, CONF_JWT_KEY, CONF_JWT_ALGORITHM)]);
    }
}