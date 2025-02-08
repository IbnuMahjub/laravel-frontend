<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    public function index()
    {
        $breadcrumbTitle = 'List Property';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/property';
        $urlCategory = env('API_URL') . '/api/category';
        $response = Http::withToken($token)->get($url);
        $category_id = Http::withToken($token)->get($urlCategory);
        // dd($response->json()['data']);
        // dd($category_id->json());
        if ($response->successful()) {
            return view('dashboard.property.index', [
                'title' => 'Property',
                'categories' => $category_id->json(),
                'properties' => $response->json()['data'],
            ]);
        } else {
            return view('errors.api_error', [
                'message' => 'Failed to fetch properties from API',
            ]);
        }
    }
    public function getUnit()
    {
        $breadcrumbTitle = 'List Unit';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/property';
        $response = Http::withToken($token)->get($url);
        if ($response->successful()) {
            return view('dashboard.property.unit', [
                'title' => 'Unit',
                'categories' => $response->json(),
            ]);
        } else {
            return view('errors.api_error', [
                'message' => 'Failed to fetch categories from API',
            ]);
        }
    }

    public function storeProperty(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'alamat' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/property';

        $response = Http::withToken($token)
            ->attach('image', fopen($request->file('image')->getRealPath(), 'r'), $request->file('image')->getClientOriginalName())
            ->post($url, [
                'name' => $validated['name'],
                'alamat' => $validated['alamat'],
                'category_id' => $validated['category_id'],
            ]);
        Log::info('API Response:', $response->json());

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'property' => $response->json()['data'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add property',
            ]);
        }
    }
}
