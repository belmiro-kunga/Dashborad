<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Exemplo de estatísticas (ajuste conforme suas tabelas reais)
        // Usa apenas a tabela padrão do Laravel
        $usuarios = DB::table('users')->count();
        // As demais estatísticas são opcionais
        $grupos = $logs = $permissoes = null;
        try { $grupos = DB::table('grupos')->count(); } catch (\Exception $e) {}
        try { $logs = DB::table('logs')->count(); } catch (\Exception $e) {}
        try { $permissoes = DB::table('permissoes')->count(); } catch (\Exception $e) {}

        return view('dashboard', [
            'usuarios' => $usuarios,
            'grupos' => $grupos,
            'logs' => $logs,
            'permissoes' => $permissoes,
        ]);
    }
}
