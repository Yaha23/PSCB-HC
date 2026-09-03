<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar formulario de login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Autenticar usuario.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $usuario = Auth::user();

        /*
         * Verificar que la cuenta esté activa.
         */
        if ($usuario->status !== 'activo') {

            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors([
                    'username' => 'Tu cuenta se encuentra inactiva. Comunícate con el administrador.',
                ])
                ->onlyInput('username');
        }

        return redirect()->intended(
            route('dashboard', absolute: false)
        );
    }

    /**
     * Cerrar sesión.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}