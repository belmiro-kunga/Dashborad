<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificacaoConfig extends Model
{
    protected $table = 'notificacao_configs';
    protected $fillable = [
        'user_id',
        'email_alerta',
        'sms_alerta',
        'push_alerta',
        'prioridade_minima',
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
