@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-stat text-center">
                <div class="card-body">
                    <div>
                        <i class="bi bi-people icon"></i>
                        <h5 class="card-title mt-2">Usuários</h5>
                    </div>
                    <h2 class="fw-bold">{{ $usuarios }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat text-center">
                <div class="card-body">
                    <div>
                        <i class="bi bi-people-fill icon"></i>
                        <h5 class="card-title mt-2">Grupos</h5>
                    </div>
                    <h2 class="fw-bold">{{ $grupos }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat text-center">
                <div class="card-body">
                    <div>
                        <i class="bi bi-shield-lock icon"></i>
                        <h5 class="card-title mt-2">Permissões</h5>
                    </div>
                    <h2 class="fw-bold">{{ $permissoes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-stat text-center">
                <div class="card-body">
                    <div>
                        <i class="bi bi-clock-history icon"></i>
                        <h5 class="card-title mt-2">Logs</h5>
                    </div>
                    <h2 class="fw-bold">{{ $logs }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card main-content">
                <div class="card-body">
                    <h4 class="mb-4">Bem-vindo ao Painel de Controle</h4>
                    <p class="lead">Aqui você pode gerenciar usuários, grupos, permissões, visualizar logs e acessar todas as funcionalidades administrativas do sistema.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
