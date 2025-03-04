<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbTitle = 'Category';
        $breadcrumbs = [
            ['title' => 'Data Category', 'url' => '/category'],
            ['title' => 'Property', 'url' => '/property'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/category';

        $response = Http::withToken($token)->get($url);

        // dd($response->json());
        if ($response->successful()) {
            return view('dashboard.category.index', [
                'title' => 'Category',
                'categories' => $response->json(),
            ]);
        } else {
            return view('errors.api_error', [
                'message' => 'Failed to fetch categories from API',
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name_category' => 'required|string',
        ]);

        $token = session('token');
        $ul = env('API_URL') . '/api/category';
        $response = Http::withToken($token)->post($ul, [
            'name_category' => $validated['name_category'],
        ]);
        // $response = Http::post($ul, [
        //     'name' => $validated['name'],
        //     'slug' => $validated['slug'],
        // ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'category' => $response->json(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $token = session('token');
        $url = env('API_URL') . '/api/category/' . $id;

        $response = Http::withToken($token)->get($url);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'category' => $response->json(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch category data',
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name_category' => 'required|string',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/category/' . $id;

        $response = Http::withToken($token)->put($url, [
            'name_category' => $validated['name_category'],
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'category' => $response->json(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category',
            ]);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = session('token');
        $url = env('API_URL') . '/api/category/' . $id;

        $response = Http::withToken($token)->delete($url);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category.',
            ]);
        }
    }
}
