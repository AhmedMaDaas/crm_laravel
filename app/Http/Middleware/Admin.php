<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\RequestException;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $message = 'Unauthorized';

    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::user()->isAdmin()){
            return $next($request);
        }
        else if($request->is('api/*')){
            throw new RequestException($this->message, null, 403);
        }
        else{
            request()->session()->flash('error','You do not have any permission to access this page');
            return redirect()->route('login.form');
        }
    }
}
