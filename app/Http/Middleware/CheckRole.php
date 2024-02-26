<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $accessRole1, $accessRole2): Response
    {
        $loggedUserRole = strval(Auth::user()->role_id);

        if ($accessRole1 == $loggedUserRole || $accessRole2 == $loggedUserRole) {
            return $next($request);
        }
        return redirect(url('error/403'));
    }
}
