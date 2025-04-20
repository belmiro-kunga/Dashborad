<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\ConfiguracoesController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/configuracoes', [ConfiguracoesController::class, 'index'])->name('configuracoes');
    Route::post('/configuracoes', [ConfiguracoesController::class, 'salvar'])->name('configuracoes.salvar');
});

// Página de login (GET)
Route::get('/login', function () {
    return view('login');
})->name('login');

// Autenticação manual (POST)
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
    return back()->with('error', 'E-mail ou senha inválidos.');
});

// Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
