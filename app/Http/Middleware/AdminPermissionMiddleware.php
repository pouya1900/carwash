<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$permission)
    {
        if (!$permission) {
            return redirect(route('admin.dashboard'))->withErrors(['error' => trans('trs.dont_have_permission')]);
        }

        $admin = $request->admin;

        if (!$admin) {
            return redirect(route('admin.dashboard'))->withErrors(['error' => trans('trs.dont_have_permission')]);
        }
        if (
            empty($admin->hasPermission($permission)) &&
            !$admin->isSuperAdmin()
        ) {
            return redirect(route('admin.dashboard'))->withErrors(['error' => trans('trs.dont_have_permission')]);
        }

        return $next($request);
    }
}
