<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WarekAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('is_warek_logged_in')) {
            return redirect()->route('warek.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
