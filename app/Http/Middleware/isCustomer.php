<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class IsCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() && $request->user()->user_type == 'C'){
            return $next($request);
        }

        throw new AuthorizationException();

    }
}
