<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // public function __construct()
    // {
    //     // Cek apakah token ada di session setiap kali user mencoba mengakses dashboard
    //     $this->middleware(function ($request, $next) {
    //         if (!session('token')) {
    //             return redirect()->route('login')->withErrors('You must be logged in to access the dashboard.');
    //         }
    //         return $next($request);
    //     });
    // }

    public function index()
    {

        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Analysis', 'url' => 'javascript:;', 'active' => true],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbsTitle = 'Dashboard');
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'active' => 'dashboard'

        ]);
    }
}
