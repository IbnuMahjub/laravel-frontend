<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function test()
    {

        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Analysis', 'url' => 'javascript:;', 'active' => true],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbsTitle = 'Dashboard');
        $token = session('token');
        $url = env('API_URL') . '/api/property';
        $urlCategory = env('API_URL') . '/api/category';
        $response = Http::withToken($token)->get($url);
        $category_id = Http::withToken($token)->get($urlCategory);

        // dd($response->json());
        return view('dashboard.test', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'categories' => $category_id->json(),
            'properties' => $response->json()['data'],

        ]);
    }
}
