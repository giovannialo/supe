<?php

session_start();
ob_start();

use LandKit\Route\Route;

require_once __DIR__ . '/vendor/autoload.php';


/*
 * Inicializa roteador
 */
Route::init(CONF_BASE_URL);


/*
 * Carrega os arquivos existentes dentro da pasta src/Routes.
 */
$path = 'src/Routes';

if ($dir = scandir($path)) {
    foreach ($dir as $file) {
        if ($file == '.' || $file == '..') {
            continue;
        }

        if (file_exists("{$path}/{$file}") && !is_dir("{$path}/{$file}")) {
            require_once "{$path}/{$file}";
        }
    }
}


/*
 * Executa roteador
 */
Route::dispatch();


/*
 * Trata erros do roteador
 */
if (Route::fail()) {
    httpErrorResponse(Route::fail());
}


ob_end_flush();