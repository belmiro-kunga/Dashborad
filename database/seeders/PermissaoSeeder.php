<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permissao;

class PermissaoSeeder extends Seeder
{
    public function run()
    {
        $permissoes = ['Administrador', 'Editor', 'Visualizador'];
        foreach ($permissoes as $nome) {
            Permissao::firstOrCreate(['nome' => $nome]);
        }
    }
}
