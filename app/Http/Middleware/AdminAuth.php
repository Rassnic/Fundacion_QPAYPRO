<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
public function handle(Request $request, Closure $next): Response
    {
        $user = env('ADMIN_USER', 'admin');
        $pass = env('ADMIN_PASS', 'secret123');

        if (
            $request->getUser() !== $user ||
            $request->getPassword() !== $pass
        ) {
            $headers = ['WWW-Authenticate' => 'Basic'];
            return response('No autorizado.', 401, $headers);
        }

        return $next($request);
    }
}
