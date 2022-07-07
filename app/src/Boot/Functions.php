<?php

use LandKit\Route\Route;


/* *** *** *** *** *** *** *** *** *** ***
 * Ativos
 * *** *** *** *** *** *** *** *** *** ***/

/**
 * @param int $code
 * @param bool $returnArray
 * @return string|null
 */
function errorByCode(int $code, bool $returnArray = true): ?string
{
    $arr = [
        11001 => 'invalido_tamanho_arquivo',
        11002 => 'invalido_tipo_arquivo',
        11003 => 'invalido_nomeInteressado',
        11004 => 'invalido_tipoInteressado',
        11005 => 'invalido_cpfCnpjInteressado',
        11006 => 'invalido_origem',
        11007 => 'invalido_codigoSecretaria',
        11008 => 'invalido_codigoSetor',
        11009 => 'invalido_codigoNatureza',
        11010 => 'invalido_tipoDocumento',
        11011 => 'invalido_anoProcesso',
        11012 => 'invalido_numeroProcesso',
        11013 => 'invalido_codigoSecretariaDestino',
        11014 => 'invalido_codigoSetorDestino',
        11015 => 'invalido_motivo',
        12001 => 'obrigatorio_nomeInteressado',
        12002 => 'obrigatorio_tipoInteressado',
        12003 => 'obrigatorio_cpfCnpjInteressado',
        12004 => 'obrigatorio_origem',
        12005 => 'obrigatorio_codigoSecretaria',
        12006 => 'obrigatorio_codigoSetor',
        12007 => 'obrigatorio_codigoNatureza',
        12008 => 'obrigatorio_tipoDocumento',
        12009 => 'obrigatorio_usuario',
        12010 => 'obrigatorio_senha',
        12011 => 'obrigatorio_hash',
        12012 => 'obrigatorio_anoProcesso',
        12013 => 'obrigatorio_numeroProcesso',
        12014 => 'obrigatorio_codigoSecretariaDestino',
        12015 => 'obrigatorio_codigoSetorDestino',
        12016 => 'obrigatorio_motivo',
        13001 => 'invalido_login',
        13002 => 'invalido_hash',
        13003 => 'invalido_token',
        14001 => 'invalido_codigoSecretaria',
        14002 => 'invalido_anoProcesso',
        14003 => 'invalido_numeroProcesso'
    ];

    return ($arr[$code] ?? null);
}

/**
 * @param int $httpResponseCode
 * @return never
 */
function httpErrorResponse(int $httpResponseCode): never
{
    http_response_code($httpResponseCode);

    $message = match ($httpResponseCode) {
        400 => 'Bad request',
        403 => 'Forbidden',
        404 => 'Not found',
        405 => 'Partially implemented',
        501 => 'Not implemented',
        default => 'Undefined',
    };

    echo json_encode([
        'erro' => $httpResponseCode,
        'data' => date('Y-m-d H:i:s'),
        'mensagem' => $message,
        'url' => Route::current()->path
    ]);

    exit;
}