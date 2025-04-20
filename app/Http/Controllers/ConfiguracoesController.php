<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;
use Illuminate\Support\Facades\Storage;

class ConfiguracoesController extends Controller
{
    public function index()
    {
        $config = Configuracao::first();
        return view('configuracoes', compact('config'));
    }

    public function salvar(Request $request)
    {
        $data = $request->validate([
            'nome_sistema' => 'required|string|max:120',
            'idioma' => 'required|string',
            'fuso_horario' => 'required|string',
            'tema' => 'nullable|string',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
        ]);

        $config = Configuracao::first() ?? new Configuracao();

        // Upload de logo
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('public/config');
            $data['logo'] = $logoPath;
        } else {
            $data['logo'] = $config->logo;
        }
        // Upload de favicon
        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('public/config');
            $data['favicon'] = $faviconPath;
        } else {
            $data['favicon'] = $config->favicon;
        }

        $config->fill($data);
        $config->save();

        return redirect()->route('configuracoes')->with('success', 'Configurações salvas com sucesso!');
    }

    public function salvarSmtp(Request $request)
    {
        $data = $request->validate([
            'mail_host' => 'required|string',
            'mail_port' => 'required|numeric',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string',
            'mail_from_address' => 'nullable|email',
            'mail_from_name' => 'nullable|string',
        ]);

        $envPath = base_path('.env');
        $env = file_get_contents($envPath);
        foreach ([
            'MAIL_HOST' => $data['mail_host'],
            'MAIL_PORT' => $data['mail_port'],
            'MAIL_USERNAME' => $data['mail_username'],
            'MAIL_PASSWORD' => $data['mail_password'],
            'MAIL_ENCRYPTION' => $data['mail_encryption'],
            'MAIL_FROM_ADDRESS' => $data['mail_from_address'],
            'MAIL_FROM_NAME' => $data['mail_from_name'],
        ] as $key => $value) {
            if (preg_match("/^{$key}=.*$/m", $env)) {
                $env = preg_replace("/^{$key}=.*$/m", $key.'='.(is_null($value)?'':$value), $env);
            } else {
                $env .= "\n{$key}=".(is_null($value)?'':$value);
            }
        }
        file_put_contents($envPath, $env);

        return redirect()->route('configuracoes')->with('success', 'Configurações SMTP salvas com sucesso!');
    }
}
