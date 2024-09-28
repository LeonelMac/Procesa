<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Enums\TipoDeUsuarioEnum;
use Illuminate\Support\Facades\Auth;

class Role
{
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();
        $userRole = $user->rol;
        if (in_array($userRole, $roles)) {
            return $next($request);
        }
        return redirect('/inicio')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
