<?php

namespace Rocklegend\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;

class Permission {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (!Sentinel::getUser()->hasAccess($permission)) {
            \App::abort(403, 'Not allowed: ' . $permission);
        }

        return $next($request);
    }
}
