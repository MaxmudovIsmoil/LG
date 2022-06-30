<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $roles = [
            'admin'     => [1],
            'editor'    => [2],
            'promoter'  => [3],
            'supervisor'=> [4],
        ];

        $roleIds = $roles[$role] ?? [];

        if (in_array(Auth::user()->roleId, $roleIds)) {
//            abort(403);
           return $this->logoutRedirect();
        }


        return $next($request);
    }

    private function logoutRedirect()
    {
        Session::flush();

        Auth::logout();

        return redirect('login');
    }
}
