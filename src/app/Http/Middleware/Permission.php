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
    public function handle($request, Closure $next)
    {
        $shouldCheck = !$request->is("login");

        if ($shouldCheck && Sentinel::check()) {
            $action = Route::getRoutes()->match($request)->getAction()['controller'];

            $ctrl = explode('@', $action);
            $ctrl = $ctrl[0];

            if (!Sentinel::getUser()->hasAnyAccess(array($action, $ctrl)))
                \App::abort(403, 'Not allowed: ' . $action);
        }

        return $next($request);
    }
}
