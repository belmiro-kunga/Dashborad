<?php
namespace App\Http\Middleware;

use Closure;
use App\Models\BlockedIp;

class Firewall
{
    public function handle($request, Closure $next)
    {
        $ip = $request->ip();
        if (BlockedIp::where('ip', $ip)->exists()) {
            abort(403, 'Acesso bloqueado pelo firewall.');
        }
        return $next($request);
    }
}
