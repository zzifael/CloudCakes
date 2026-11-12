<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check() || !in_array(Auth::user()->role, $roles)) {
           abort(403, 'Akses Ditolak: Anda tidak memiliki wewenang membuka halaman ini.');
        }
        return $next($request);
    }
}
