<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckJabatan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next, ...$roles)
    {
        // Cek apakah jabatan user termasuk dalam role yang diizinkan
        if (! in_array($request->user()->jabatan, $roles)) {
            // return redirect('/')->with('error', 'Akses ditolak!');
            return redirect()
                ->route('access.denied')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        return $next($request);
    }
}
