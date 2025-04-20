@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Configurações de Notificações e Alertas</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('notificacoes.config.salvar') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Canais de Alerta:</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="email_alerta" value="1" id="email_alerta" {{ $config->email_alerta ? 'checked' : '' }}>
                <label class="form-check-label" for="email_alerta">E-mail</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sms_alerta" value="1" id="sms_alerta" {{ $config->sms_alerta ? 'checked' : '' }}>
                <label class="form-check-label" for="sms_alerta">SMS</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="push_alerta" value="1" id="push_alerta" {{ $config->push_alerta ? 'checked' : '' }}>
                <label class="form-check-label" for="push_alerta">Push Notification</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="prioridade_minima" class="form-label">Prioridade mínima para notificação:</label>
            <select class="form-select" name="prioridade_minima" id="prioridade_minima">
                <option value="baixa" {{ $config->prioridade_minima=='baixa' ? 'selected' : '' }}>Baixa</option>
                <option value="media" {{ $config->prioridade_minima=='media' ? 'selected' : '' }}>Média</option>
                <option value="alta" {{ $config->prioridade_minima=='alta' ? 'selected' : '' }}>Alta</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Configurações</button>
    </form>
</div>
@endsection
