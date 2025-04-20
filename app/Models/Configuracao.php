<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'configuracoes';
    protected $fillable = [
        'nome_sistema', 'idioma', 'fuso_horario', 'tema', 'logo', 'favicon'
    ];
}
