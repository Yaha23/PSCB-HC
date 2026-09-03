<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Verifica que el usuario tenga una cuenta activa.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si no está autenticado, continúa.
        // El middleware auth se encargará de enviarlo al login.
        if (!Auth::check()) {
            return $next($request);
        }

        $usuario = Auth::user();

        // Si la cuenta NO está activa
        if ($usuario->status !== 'activo') {

            // Cerrar sesión
            Auth::logout();

            // Invalidar sesión
            $request->session()->invalidate();

            // Generar nuevo token
            $request->session()->regenerateToken();

            // Regresar al login con mensaje
            return redirect()
                ->route('login')
                ->withErrors([
                    'username' => 'Tu cuenta se encuentra inactiva. Comunícate con el administrador.',
                ]);
        }

        return $next($request);
    }
}