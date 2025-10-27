<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $isAdmin = false;

        if ($user) {
            if (isset($user->is_admin)) {
                $isAdmin = (bool)$user->is_admin;
            }
            if (!$isAdmin && method_exists($user, 'isAdmin')) {
                $isAdmin = (bool)$user->isAdmin();
            }
            if (!$isAdmin && isset($user->role)) {
                $isAdmin = ($user->role === 'admin');
            }
        }

        if (!$user || !$isAdmin) {
            abort(route('story.index'), 'Unauthorized.');
        }

        return $next($request);
    }
}

