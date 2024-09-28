<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Las credenciales proporcionadas no son correctas.']);
        }
        if ($user->lockout_time && now()->lessThan($user->lockout_time)) {
            $remainingTime = $user->lockout_time->diffInSeconds(now());
            return response()->json([
                'success' => false,
                'message' => 'Demasiados intentos fallidos. Por favor, intente nuevamente en ' . ceil($remainingTime / 60) . ' minutos.',
                'remaining_time' => $remainingTime,
            ], 429);
        }
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user->update([
                'login_attempts' => 0,
                'lockout_time' => null,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Bienvenido a Procesa, ' . $user->nombres . ' ' . $user->apellidoP . ' ' . $user->apellidoM
            ]);
        }
        $user->increment('login_attempts');
        if ($user->login_attempts >= 3) {
            $user->update([
                'lockout_time' => now()->addMinutes(1), 
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Demasiados intentos fallidos. Por favor, intente nuevamente en 1 minuto.',
                'remaining_time' => 60, 
            ], 429);
        }
        return response()->json(['success' => false, 'message' => 'Las credenciales proporcionadas no son correctas.']);
    }

    public function checkLockout(Request $request)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();
        if ($user && $user->lockout_time && now()->lessThan($user->lockout_time)) {
            $remainingTime = $user->lockout_time->diffInSeconds(now());
            return response()->json([
                'is_locked' => true,
                'message' => 'Demasiados intentos fallidos. Por favor, intente nuevamente en ' . ceil($remainingTime / 60) . ' minutos.',
                'remaining_time' => $remainingTime,
            ]);
        }
        return response()->json(['is_locked' => false]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
