<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $route_name = $request->route()->action['as'];
        if ($route_name) {
            $user = auth()->user();
            try {
                if (!$user->hasPermissionTo($route_name)) {
                    abort(403, '您没有权限, '. $route_name);
                }
            } catch (PermissionDoesNotExist $e) {
                // TODO 路由没有录入到权限里面去
            }
        }
        return $next($request);
    }
}
