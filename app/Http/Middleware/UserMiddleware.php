<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
         if (!auth()->check() || auth()->user()->isAdmin()) {
            abort(403, 'Доступ запрещен');
        }

        return $next($request);
    }
}
