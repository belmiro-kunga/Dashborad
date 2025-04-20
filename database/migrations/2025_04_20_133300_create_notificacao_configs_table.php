<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('notificacao_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('email_alerta')->default(true);
            $table->boolean('sms_alerta')->default(false);
            $table->boolean('push_alerta')->default(false);
            $table->enum('prioridade_minima', ['baixa','media','alta'])->default('baixa');
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists('notificacao_configs');
    }
};
