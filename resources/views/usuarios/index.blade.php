@extends('layouts.app')
@section('content')
<div class="container">
    <h3 class="mb-4">Gestão de Usuários e Permissões</h3>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('usuarios.store') }}" class="row g-3 mb-4">
        @csrf
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" placeholder="Nome" required>
        </div>
        <div class="col-md-4">
            <input type="email" name="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="col-md-3">
            <input type="password" name="password" class="form-control" placeholder="Senha" required>
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
        @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <form method="POST" action="{{ route('usuarios.updatePermissoes', $usuario->id) }}">
                        @csrf
                        @foreach($permissoes as $permissao)
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
</div>
@endsection
