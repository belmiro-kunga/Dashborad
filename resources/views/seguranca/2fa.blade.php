@extends('layouts.app')
@section('content')
<div class="container">
    <h2>Autenticação de Dois Fatores (2FA)</h2>
    @if($user->two_factor_enabled)
        <div class="alert alert-success">2FA está <strong>ATIVADA</strong> para sua conta.</div>
        <form method="POST" action="{{ route('2fa.disable') }}">
            @csrf
            <button type="submit" class="btn btn-danger">Desativar 2FA</button>
        </form>
    @else
        <div class="alert alert-info">2FA está <strong>DESATIVADA</strong> para sua conta.</div>
        <p>1. Escaneie o QR Code abaixo com seu aplicativo autenticador (Google Authenticator, Authy, etc).</p>
        <div class="mb-3">{!! $QR_Image !!}</div>
        <p>2. Digite o código gerado pelo aplicativo para ativar:</p>
        <form method="POST" action="{{ route('2fa.enable') }}">
            @csrf
            <div class="mb-3">
                <input type="text" name="code" class="form-control w-auto d-inline" maxlength="6" required autofocus placeholder="Código">
                @error('code')<span class="text-danger ms-2">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="btn btn-success">Ativar 2FA</button>
        </form>
    @endif
    <a href="{{ route('configuracoes') }}" class="btn btn-link mt-4">Voltar às Configurações</a>
</div>
@endsection
