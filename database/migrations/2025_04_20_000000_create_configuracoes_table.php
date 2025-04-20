<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome_sistema', 120)->default('Meu Painel');
            $table->string('idioma', 10)->default('pt_AO');
            $table->string('fuso_horario', 40)->default('America/Sao_Paulo');
            $table->string('tema', 20)->default('claro');
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('configuracoes');
    }
};
