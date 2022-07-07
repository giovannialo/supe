<?php

namespace Source\Models;

use LandKit\Model\Model;

class UserApiModel extends Model
{
    /**
     * @var string
     */
    protected string $table = 'usuario_api';

    /**
     * @var array|string[]|null
     */
    protected ?array $required = [
        'usuario',
        'senha',
        'hash'
    ];

    /**
     * @const string
     */
    public const CREATED_AT = 'criado_em';

    /**
     * @const string
     */
    public const UPDATED_AT = 'atualizado_em';
}