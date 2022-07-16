<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Exceptions\RequestException;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    private $message = 'Unauthenticated';

    protected function redirectTo($request)
    {
        if($request->is('api/*')){
            throw new RequestException($this->message, null, 401);
        }

        if (! $request->expectsJson()) {
            return route('login.form');
        }
    }
}
