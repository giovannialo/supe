<?php

namespace Source\Api;

interface ApiInterface
{
    /**
     * @const int
     */
    const BAD_REQUEST = 400;

    /**
     * @const int
     */
    const UNAUTHORIZED = 401;

    /**
     * @const int
     */
    const FORBIDDEN = 403;

    /**
     * @const int
     */
    const NOT_FOUND = 404;

    /**
     * @const int
     */
    const INTERNAL_SERVER = 500;
}