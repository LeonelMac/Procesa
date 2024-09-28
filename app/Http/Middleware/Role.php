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
        $userRole = $user->rol; // Obtenemos el rol del usuario

        // Si el usuario tiene uno de los roles permitidos
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Si no tiene el rol permitido, redirigir
        return redirect('/inicio')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}