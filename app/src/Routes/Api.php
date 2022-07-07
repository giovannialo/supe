<?php

use LandKit\Route\Route;
use Source\Http\Middleware\JWTAuthMiddleware;

/*
 * Api
 */
Route::controller('Source\Api');
Route::session('api/v1');

/*
 * Api: autenticação
 */
Route::post('/autenticar', 'AuthApi:signIn');

/*
 * Api: processo
 */
Route::post('/processos', 'ProcessApi:open', 'supe.api.process.open', JWTAuthMiddleware::class);
Route::post('/processos/receber', 'ProcessApi:receive', middleware: JWTAuthMiddleware::class);
Route::post('/processos/tramitar', 'ProcessApi:proceed', middleware: JWTAuthMiddleware::class);
Route::post('/processos/redirecionar', 'ProcessApi:redirect', middleware: JWTAuthMiddleware::class);
Route::get('/processos/{secretary}/{number}/{year}', 'ProcessApi:consult', middleware: JWTAuthMiddleware::class);
Route::get('/processos/origens', 'ProcessApi:origin');

/*
 * Api: secretaria
 */
Route::get('/secretarias', 'SecretaryApi:index');

/*
 * Api: setor
 */
Route::get('/setores/ativos/{secretary}', 'SectorApi:activeBySecretariat');

/*
 * Api: natureza
 */
Route::get('/naturezas/secretarias/{secretary}', 'NatureApi:activeBySecretariat');
