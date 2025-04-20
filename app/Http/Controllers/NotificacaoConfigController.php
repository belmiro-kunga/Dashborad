<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NotificacaoConfig;
use Illuminate\Support\Facades\Auth;

class NotificacaoConfigController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $config = NotificacaoConfig::firstOrCreate(['user_id' => $user->id]);
        return view('notificacoes.config', compact('config'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $data = $request->validate([
            'email_alerta' => 'boolean',
            'sms_alerta' => 'boolean',
            'push_alerta' => 'boolean',
            'prioridade_minima' => 'required|in:baixa,media,alta',
        ]);
        $config = NotificacaoConfig::firstOrCreate(['user_id' => $user->id]);
        $config->update($data);
        return back()->with('success', 'Configurações de notificação salvas!');
    }
}
