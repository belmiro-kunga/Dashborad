<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function permissoes()
    {
        return $this->belongsToMany(\App\Models\Permissao::class, 'permissao_user');
    }

    public function hasPermissao($nome)
    {
        return $this->permissoes->contains('nome', $nome);
    }
    public function isAdministrador()
    {
        return $this->hasPermissao('Administrador');
    }
    public function isEditor()
    {
        return $this->hasPermissao('Editor');
    }
    public function isVisualizador()
    {
        return $this->hasPermissao('Visualizador');
    }


    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
