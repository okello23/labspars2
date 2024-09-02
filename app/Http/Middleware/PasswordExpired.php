<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class PasswordExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        $password_updated_at = new Carbon(($user->password_updated_at) ? $user->password_updated_at : $user->created_at);

        if (Carbon::now()->diffInDays($password_updated_at) >= config('auth.password_expires_days')) {
            return redirect()->route('user.account')->with('password_change', 'Dear '.$user->name.', You need to change your password now as per the existing password policy!');
        }

        return $next($request);
    }
}
