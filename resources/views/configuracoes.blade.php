@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Configurações Gerais</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('configuracoes.salvar') }}" enctype="multipart/form-data" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label for="nome_sistema" class="form-label">Nome do sistema</label>
            <input type="text" class="form-control" id="nome_sistema" name="nome_sistema" value="{{ old('nome_sistema', $config->nome_sistema ?? '') }}" required>
        </div>
        <div class="col-md-3">
            <label for="idioma" class="form-label">Idioma</label>
            <select class="form-select" id="idioma" name="idioma">
    <option value="pt_AO" @if(($config->idioma ?? '')=='pt_AO') selected @endif>Português (Angola)</option>
    <option value="en" @if(($config->idioma ?? '')=='en') selected @endif>Inglês</option>
    <option value="es" @if(($config->idioma ?? '')=='es') selected @endif>Espanhol</option>
</select>
        </div>
        <div class="col-md-3">
            <label for="fuso_horario" class="form-label">Fuso horário</label>
            <select class="form-select" id="fuso_horario" name="fuso_horario">
    <option value="Africa/Luanda" @if(($config->fuso_horario ?? '')=='Africa/Luanda') selected @endif>GMT+1 (Angola/Luanda)</option>
    <option value="America/Sao_Paulo" @if(($config->fuso_horario ?? '')=='America/Sao_Paulo') selected @endif>GMT-3 (Brasília)</option>
    <option value="UTC" @if(($config->fuso_horario ?? '')=='UTC') selected @endif>UTC</option>
    <option value="Europe/Lisbon" @if(($config->fuso_horario ?? '')=='Europe/Lisbon') selected @endif>Lisboa</option>
</select>
        </div>
        <div class="col-md-4">
            <label for="tema" class="form-label">Tema</label>
            <select class="form-select" id="tema" name="tema">
                <option value="claro" @if(($config->tema ?? '')=='claro') selected @endif>Claro</option>
                <option value="escuro" @if(($config->tema ?? '')=='escuro') selected @endif>Escuro</option>
            </select>
        </div>
        <div class="col-md-4">
            <label for="logo" class="form-label">Logo</label>
            <input type="file" class="form-control" id="logo" name="logo" accept="image/*">
            @if(!empty($config->logo))
                <img src="{{ Storage::url($config->logo) }}" alt="Logo" class="mt-2" style="max-height: 40px;">
            @endif
        </div>
        <div class="col-md-4">
            <label for="favicon" class="form-label">Favicon</label>
            <input type="file" class="form-control" id="favicon" name="favicon" accept="image/*">
            @if(!empty($config->favicon))
                <img src="{{ Storage::url($config->favicon) }}" alt="Favicon" class="mt-2" style="max-height: 32px;">
            @endif
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Salvar configurações</button>
        </div>
    </form>
</div>
@endsection
