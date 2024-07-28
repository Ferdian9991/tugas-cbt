<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class peserta
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = Auth::user();
        if (!empty($auth) && !$auth?->is_active) {
            abort(403, 'Akun Anda Belum Aktif!');
        }

        if ($auth?->role === User::ROLE_USER) {
            return $next($request);
        }

        abort(403, 'Tidak Memiliki Akses!');
    }
}
