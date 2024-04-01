<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NotCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() && $request->user()->user_type != 'C'){
            return $next($request);
        }
        throw new AuthorizationException();

    }
}
