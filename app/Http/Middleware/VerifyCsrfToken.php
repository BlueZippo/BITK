<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'chrome/*',
        'http://localhost:3000',
        'http://phpstack-93963-566910.cloudwaysapps.com/chrome/*'
    ];
}
