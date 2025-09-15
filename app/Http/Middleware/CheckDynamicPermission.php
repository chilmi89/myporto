<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionRoute;

class CheckDynamicPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
     public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Anda harus login.');
        }

        // Ambil nama route yang sedang diakses
        $routeName = $request->route()->getName();

        // Ambil permission yang terkait route ini dari tabel permission_routes
        $permission = PermissionRoute::where('route_name', $routeName)->first()?->permission_name;

        // Jika ada permission, cek apakah user memiliki permission itu
        if ($permission && !$user->can($permission)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
