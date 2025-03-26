<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function setTheme(Request $request)
    {
        $theme = $request->input('theme', 'blue');
        session(['theme' => $theme]);
        return response()->json(['success' => true]);
    }

    public function index()
    {

        $url = env('API_URL') . '/api/data_property';
        $response = Http::get($url);
        // dd($response->json()['data']);
        if ($response->successful()) {
            return view('home', [
                'title' => 'Home',
                'data' => $response->json()['data']
            ]);
        }
    }

    public function showProperties($slug)
    {
        $url = env('API_URL') . '/api/data_property/' . $slug;
        $response = Http::get($url);
        // dd($response->json()['data']);
        if ($response->successful()) {
            return view('detail', [
                'title' => 'Home',
                'data' => $response->json()['data']
            ]);
        }
    }
}
