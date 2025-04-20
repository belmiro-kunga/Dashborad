<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SistemaController extends Controller
{
    public function backup()
    {
        $filename = 'backup_' . date('Ymd_His') . '.sql';
        $path = storage_path('app/backups');
        if (!is_dir($path)) mkdir($path, 0777, true);
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $port = env('DB_PORT', 3306);
        $dumpCommand = "mysqldump -h{$host} -P{$port} -u{$user} --password=\"{$pass}\" {$db} > {$path}/{$filename}";
        $result = null;
        $output = null;
        exec($dumpCommand, $output, $result);
        if ($result === 0) {
            return response()->download("{$path}/{$filename}");
        } else {
            return back()->with('error', 'Erro ao gerar backup. Verifique as configurações do banco e permissões do sistema.');
        }
    }

    public function restaurar(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file',
        ]);
        $file = $request->file('backup_file');
        $path = $file->storeAs('backups', 'restore_' . Str::random(8) . '.sql');
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');
        $port = env('DB_PORT', 3306);
        $restoreCommand = "mysql -h{$host} -P{$port} -u{$user} --password=\"{$pass}\" {$db} < " . storage_path('app/'.$path);
        $result = null;
        $output = null;
        exec($restoreCommand, $output, $result);
        if ($result === 0) {
            return back()->with('success', 'Backup restaurado com sucesso!');
        } else {
            return back()->with('error', 'Erro ao restaurar backup. Verifique o arquivo e as permissões.');
        }
    }
}
