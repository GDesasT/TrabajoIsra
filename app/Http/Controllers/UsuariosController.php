<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Game;

class UsuariosController extends Controller
{
    public function vistaLogin()
    {
        return view('usuarios.login');
    }

    public function logear(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }
    
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function history()
    {
        $games = Game::with('player1', 'moves')->get();
        return view('game.history', compact('games'));
    }
    
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login/vista');
}

    public function vistaRegistro()
    {
        return view('usuarios.registro');
    }

    public function registrar(Request $request)
    {


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login/vista');
    }

    public function vistaPerfil()
    {
        return view('usuarios.perfil');
    }
}