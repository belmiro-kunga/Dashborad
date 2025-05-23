<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('permissoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 40)->unique();
            $table->timestamps();
        });
        Schema::create('permissao_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('permissao_id')->constrained('permissoes')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('permissao_user');
        Schema::dropIfExists('permissoes');
    }
};
