<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotProperRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'supper_admin' && !$request->is('supper_admin*')) {
            return redirect()->route('supper_admin.dashboard');
        }

        if ($user->role === 'admin' && !$request->is('admin*')) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}

