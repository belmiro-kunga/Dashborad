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
    <hr class="my-5">
    <h4 class="mb-3">Gestão de Usuários e Permissões</h4>
    @if(session('success_user'))
        <div class="alert alert-success">{{ session('success_user') }}</div>
    @endif
    <form method="POST" action="{{ route('usuarios.store') }}" class="row g-3 mb-4">
    @csrf
    <div class="col-md-3">
        <input type="text" name="name" class="form-control" placeholder="Nome" required>
    </div>
    <div class="col-md-3">
        <input type="email" name="email" class="form-control" placeholder="E-mail" required>
    </div>
    <div class="col-md-2">
        <input type="password" name="password" class="form-control" placeholder="Senha" required>
    </div>
    <div class="col-md-3">
        <div class="d-flex flex-wrap gap-2">
            @foreach(App\Models\Permissao::all() as $permissao)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissoes[]" value="{{ $permissao->id }}" id="permissao_new_{{ $permissao->id }}">
                    <label class="form-check-label" for="permissao_new_{{ $permissao->id }}">{{ $permissao->nome }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="col-md-1">
        <button type="submit" class="btn btn-primary w-100">Adicionar</button>
    </div>
</form>
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Permissões</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @foreach(App\Models\User::with('permissoes')->get() as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <form method="POST" action="{{ route('usuarios.updatePermissoes', $usuario->id) }}">
                        @csrf
                        @foreach(App\Models\Permissao::all() as $permissao)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="permissoes[]" value="{{ $permissao->id }}" id="p{{ $usuario->id }}_{{ $permissao->id }}"
                                    {{ $usuario->permissoes->contains($permissao->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="p{{ $usuario->id }}_{{ $permissao->id }}">{{ $permissao->nome }}</label>
                            </div>
                        @endforeach
                        <button type="submit" class="btn btn-sm btn-outline-primary ms-2">Salvar</button>
                    </form>
                </td>
                <td>
                    <form method="POST" action="{{ route('usuarios.destroy', $usuario->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <hr class="my-5">
    <h2>Configurações de Sistema</h2>

    <hr class="my-5">


    <form method="POST" action="{{ route('configuracoes.smtp.salvar') }}" class="card mb-4">
        @csrf
        <div class="card-header bg-secondary text-white">
            <i class="bi bi-envelope"></i> Configuração de SMTP (E-mail)
        </div>
        <div class="card-body row g-3">
            <div class="col-md-4">
                <label for="mail_host" class="form-label">Host SMTP</label>
                <input type="text" class="form-control" id="mail_host" name="mail_host" value="{{ env('MAIL_HOST') }}" required>
            </div>
            <div class="col-md-2">
                <label for="mail_port" class="form-label">Porta</label>
                <input type="number" class="form-control" id="mail_port" name="mail_port" value="{{ env('MAIL_PORT') }}" required>
            </div>
            <div class="col-md-3">
                <label for="mail_username" class="form-label">Usuário</label>
                <input type="text" class="form-control" id="mail_username" name="mail_username" value="{{ env('MAIL_USERNAME') }}">
            </div>
            <div class="col-md-3">
                <label for="mail_password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="mail_password" name="mail_password" value="{{ env('MAIL_PASSWORD') }}">
            </div>
            <div class="col-md-3">
                <label for="mail_encryption" class="form-label">Criptografia</label>
                <select class="form-select" id="mail_encryption" name="mail_encryption">
                    <option value="" {{ env('MAIL_ENCRYPTION')=='' ? 'selected' : '' }}>Nenhuma</option>
                    <option value="tls" {{ env('MAIL_ENCRYPTION')=='tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ env('MAIL_ENCRYPTION')=='ssl' ? 'selected' : '' }}>SSL</option>
                </select>
            </div>
            <div class="col-md-5">
                <label for="mail_from_address" class="form-label">Remetente (From)</label>
                <input type="email" class="form-control" id="mail_from_address" name="mail_from_address" value="{{ env('MAIL_FROM_ADDRESS') }}">
            </div>
            <div class="col-md-4">
                <label for="mail_from_name" class="form-label">Nome do Remetente</label>
                <input type="text" class="form-control" id="mail_from_name" name="mail_from_name" value="{{ env('MAIL_FROM_NAME') }}">
            </div>
            <div class="col-12 text-end mt-3">
                <button type="submit" class="btn btn-primary">Salvar SMTP</button>
            </div>
        </div>
    </form>

    <div class="card mb-4">
        <div class="card-header bg-info text-white">
            <i class="bi bi-bell"></i> Notificações e Alertas
        </div>
        <div class="card-body">
            <p>Personalize como deseja ser alertado pelo sistema (e-mail, SMS, push notification) e defina o nível mínimo de prioridade para ser notificado.</p>
            <a href="{{ route('notificacoes.config') }}" class="btn btn-outline-info">
                <i class="bi bi-gear"></i> Configurar Notificações
            </a>
        </div>
    </div>

</div>
@endsection
