<?php

use LandKit\LoadFileEnv\LoadFileEnv;


/*
 * Carrega as variáveis de ambiente (.env)
 */
if (!LoadFileEnv::load(__DIR__ . '/../../')) {
    http_response_code(500);
    echo 'O arquivo .env não foi encontrado';
    exit;
}


/*
 * URL do sistema
 */
$https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : null);
define('CONF_BASE_URL', "http{$https}://" . getenv('HOST') . '/supe');


/*
 * Banco de dados
 */
$databaseKey = getenv('DATABASE_KEY');
$databaseDriver = getenv('DATABASE_DRIVER');
$databaseHost = getenv('DATABASE_HOST');
$databasePort = getenv('DATABASE_PORT');
$databaseDbname = getenv('DATABASE_DBNAME');
$databaseUsername = getenv('DATABASE_USERNAME');
$databasePassword = getenv('DATABASE_PASSWORD');
$databaseOptions = getenv('DATABASE_OPTIONS');

if (!$databaseKey || !$databaseDriver || !$databaseHost || !$databasePort
    || !$databaseDbname || !$databaseUsername || !$databasePassword
) {
    http_response_code(500);
    echo 'As configurações de banco de dados no arquivo .env não foram devidamente preenchidas';
    exit;
}

$database = [];
$databaseKey = explode(';', $databaseKey);
$databaseDriver = explode(';', $databaseDriver);
$databaseHost = explode(';', $databaseHost);
$databasePort = explode(';', $databasePort);
$databaseDbname = explode(';', $databaseDbname);
$databaseUsername = explode(';', $databaseUsername);
$databasePassword = explode(';', $databasePassword);
$databaseOptions = explode(';', $databaseOptions);

foreach ($databaseKey as $i => $value) {
    if (!is_numeric($databasePort)) {
        echo 'As configurações de banco de dados no arquivo .env não foram devidamente preenchidas';
        exit;
    }

    $database[$value] = [
        'driver' => $databaseDriver[$i],
        'host' => $databaseHost[$i],
        'port' => (int) $databasePort[$i],
        'dbname' => $databaseDbname[$i],
        'username' => $databaseUsername[$i],
        'password' => $databasePassword[$i]
    ];

    if ($databaseOptions[$i]) {
        parse_str($databaseOptions[$i], $options);
        $database[$value]['options'] = array_map(fn($item) => (is_numeric($item) ? (int) $item : $item), $options);
    }
}

define('CONF_DATABASE', $database);


/*
 * JWT
 */
define('CONF_JWT_KEY', getenv('JWT_KEY'));
define('CONF_JWT_ALGORITHM', getenv('JWT_ALGORITHM'));


/*
 * Supe API
 */
$supeApiAuthSecretaryCode = getenv('SUPE_API_AUTH_SECRETARY_CODE');
$supeApiAuthUsername = getenv('SUPE_API_AUTH_USERNAME');
$supeApiAuthPassword = getenv('SUPE_API_AUTH_PASSWORD');
$supeApiAuthHash = getenv('SUPE_API_AUTH_HASH');
$supeApiProtocolSector = getenv('SUPE_API_PROTOCOL_SECTOR');
$supeApiUrlAuth = getenv('SUPE_API_URL_AUTH');
$supeApiUrlProtocol = getenv('SUPE_API_URL_PROTOCOL');
$supeApiDefaultSecretaryCode = getenv('SUPE_API_DEFAULT_SECRETARY_CODE');

if (!$supeApiAuthSecretaryCode || !$supeApiAuthUsername || !$supeApiAuthPassword || !$supeApiAuthHash
    || !$supeApiProtocolSector || !$supeApiUrlAuth || !$supeApiUrlProtocol || !$supeApiDefaultSecretaryCode
    || !is_numeric($supeApiDefaultSecretaryCode)
) {
    http_response_code(500);
    echo 'As configurações da API do Supe no arquivo .env não foram devidamente preenchidas';
    exit;
}

$supeApi = [];
$supeApiAuthSecretaryCode = explode(';', $supeApiAuthSecretaryCode);
$supeApiAuthUsername = explode(';', $supeApiAuthUsername);
$supeApiAuthPassword = explode(';', $supeApiAuthPassword);
$supeApiAuthHash = explode(';', $supeApiAuthHash);
$supeApiProtocolSector = explode(';', $supeApiProtocolSector);

foreach ($supeApiAuthSecretaryCode as $i => $value) {
    if (!is_numeric($supeApiAuthSecretaryCode) || !is_numeric($supeApiProtocolSector)) {
        echo 'As configurações da API do Supe no arquivo .env não foram devidamente preenchidas';
        exit;
    }

    $supeApi[$value] = [
        'auth' => [
            'login' => $supeApiAuthUsername[$i],
            'senha' => $supeApiAuthPassword[$i],
            'hashSistema' => $supeApiAuthHash[$i],
        ],
        'protocolSector' => $supeApiProtocolSector[$i]
    ];
}

define('CONF_SUPE_API', $supeApi);
define('CONF_SUPE_API_URL_AUTH', $supeApiUrlAuth);
define('CONF_SUPE_API_URL_PROTOCOL', $supeApiUrlProtocol);
define('CONF_SUPE_API_DEFAULT_SECRETARY_CODE', (int) $supeApiDefaultSecretaryCode);
