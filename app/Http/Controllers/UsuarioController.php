<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::with('permissoes')->get();
        $permissoes = Permissao::all();
        return view('usuarios.index', compact('usuarios', 'permissoes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:60',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'permissoes' => 'array',
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        $user->permissoes()->sync($data['permissoes'] ?? []);
        return redirect()->route('configuracoes')->with('success_user','Usuário criado!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('configuracoes')->with('success_user','Usuário removido!');
    }

    public function updatePermissoes(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->permissoes()->sync($request->input('permissoes', []));
        return redirect()->route('configuracoes')->with('success_user','Permissões atualizadas!');
    }
}
