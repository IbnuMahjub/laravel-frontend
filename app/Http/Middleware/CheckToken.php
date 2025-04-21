<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('token')) {
            return redirect()->route('login')->withErrors('You must be logged in to access the dashboard.');
        }

        $loginTime = session('login_time');
        $now = now();

        if ($loginTime && $now->diffInMinutes($loginTime) >= 24) {
            $token = session('token');
            $url = env('API_URL') . '/api/logout';

            try {
                Http::withToken($token)->post($url);
            } catch (\Exception $e) {
                return redirect()->route('login')->withErrors('Your session has expired. Please login again.');
            }

            Session::forget('token');
            Session::forget('user');
            Session::forget('login_time');
            Session::flush();

            return redirect()->route('login')->withErrors('Your session has expired. Please login again.');
        }


        return $next($request);
    }
}
