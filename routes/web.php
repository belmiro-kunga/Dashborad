<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\SistemaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

// Página inicial

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    Route::get('/seguranca/2fa', [\App\Http\Controllers\TwoFactorController::class, 'show'])->name('2fa.show');
    Route::post('/seguranca/2fa/enable', [\App\Http\Controllers\TwoFactorController::class, 'enable'])->name('2fa.enable');
    Route::post('/seguranca/2fa/disable', [\App\Http\Controllers\TwoFactorController::class, 'disable'])->name('2fa.disable');
    Route::post('/configuracoes/smtp', [ConfiguracoesController::class, 'salvarSmtp'])->name('configuracoes.smtp.salvar');
    Route::get('/notificacoes/config', [\App\Http\Controllers\NotificacaoConfigController::class, 'edit'])->name('notificacoes.config');
    Route::post('/notificacoes/config', [\App\Http\Controllers\NotificacaoConfigController::class, 'update'])->name('notificacoes.config.salvar');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/configuracoes', [ConfiguracoesController::class, 'index'])->name('configuracoes');
    Route::post('/configuracoes', [ConfiguracoesController::class, 'salvar'])->name('configuracoes.salvar');
    Route::resource('usuarios', UsuarioController::class)->except(['show', 'edit', 'update', 'create']);
    Route::post('usuarios/{usuario}/permissoes', [UsuarioController::class, 'updatePermissoes'])->name('usuarios.updatePermissoes');
});

// Rotas protegidas por permissão de Administrador
Route::middleware(['auth', 'permission:Administrador'])->group(function () {
    Route::post('/sistema/backup', [SistemaController::class, 'backup'])->name('sistema.backup');
    Route::post('/sistema/restaurar', [SistemaController::class, 'restaurar'])->name('sistema.restaurar');
});

// Página de login (GET)
Route::get('/login', function () {
    return view('login');
})->name('login');

// Autenticação manual (POST)
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


