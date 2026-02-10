<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        $user = auth()->user();
        
        // Jika user tidak punya role yang diizinkan
        if (!in_array($user->role, $roles)) {
            // Redirect ke dashboard sesuai role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isPetugas()) {
                return redirect()->route('petugas.dashboard');
            } elseif ($user->isSiswa()) {
                return redirect()->route('peminjam.beranda');
            }
            
            abort(403, 'Unauthorized access');
        }
        
        return $next($request);
    }
}