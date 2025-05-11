<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        $userRole = json_decode(Auth::user()->role, true) ?? [];
        
        // Convert roles string to an array (e.g., 'admin,user' => ['admin', 'user'])
        $allowedRoles = explode('|', $roles);
        if (array_intersect($userRole, $allowedRoles)) {
            return $next($request);
        }
        return redirect('errors.403')->withErrors('Unauthorized Access');
        
    }
}

