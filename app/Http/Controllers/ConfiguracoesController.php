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
}
