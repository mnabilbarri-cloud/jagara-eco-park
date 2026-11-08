<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Check if the request comes from the admin area
            if ($request->is('admin/*') || $request->is('admin') || $request->is('dashboard') || $request->is('fasilitas-admin') || $request->is('reservasi-admin')) {
                return route('login'); // Admin login is currently mapped to route('login')
            }
            // For regular customers, force redirect to the client login page
            return route('user.login'); 
        }
        return null;
    }
}
