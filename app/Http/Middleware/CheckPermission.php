<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles; 

class CheckPermission
{
    public function handle($request, Closure $next, $permission)
    {
        // Check if the user has the required permission
        if (Auth::user() && Auth::user()->hasPermissionTo($permission)) {
            return $next($request);
        }

        // If the user does not have the required permission, redirect or show an error
        abort(403, 'You do not have this permission.');
    }
}

