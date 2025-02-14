<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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

        try {
            $response = Http::withToken($token)->get($url);
            $category_id = Http::withToken($token)->get($urlCategory);

            if ($response->successful()) {
                return view('dashboard.property.index', [
                    'title' => 'Property',
                    'categories' => $category_id->json(),
                    'properties' => $response->json()['data'],
                ]);
            } else {
                return view('errors.api_error', [
                    'message' => 'Failed to fetch properties from API. Please try again later.',
                ]);
            }
        } catch (\Exception $e) {
            Session::forget('token');
            Session::forget('user');
            return redirect('/login')->with('error', 'Maaf, terjadi gangguan API. Silahkan mohon menunggu.');
        }
    }


    public function showProperty($id)
    {
        $breadcrumbTitle = 'Detail Property';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        $token = session('token');
        $url = env('API_URL') . '/api/property/' . $id;
        $urlCategory = env('API_URL') . '/api/category';
        $response = Http::withToken($token)->get($url);
        $category_id = Http::withToken($token)->get($urlCategory);
        // dd($response->json());
        if ($response->successful()) {
            return view('dashboard.property.show', [
                'title' => 'Property',
                'categories' => $category_id->json(),
                'property' => $response->json()['data'],
            ]);
        } else {
            return view('errors.api_error', [
                'message' => 'Failed to fetch property data',
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
            Log::info('API Response Successful', $response->json()['data']);
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

    public function editProperty($id)
    {
        $token = session('token');
        $url = env('API_URL') . '/api/property/' . $id;
        $urlCategory = env('API_URL') . '/api/category';
        $response = Http::withToken($token)->get($url);
        $category_id = Http::withToken($token)->get($urlCategory);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'property' => $response->json()['data'],
                'categories' => $category_id->json(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch property data',
            ]);
        }
    }

    public function updateProperty(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'alamat' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/property/' . $id;

        $data = [
            'name' => $validated['name'],
            'alamat' => $validated['alamat'],
            'category_id' => $validated['category_id'],
            '_method' => 'PUT',
        ];

        Log::info('Data:', $data);
        if ($request->hasFile('image')) {
            $response = Http::withToken($token)
                ->attach('image', fopen($request->file('image')->getRealPath(), 'r'), $request->file('image')->getClientOriginalName())
                ->post($url, $data);
        } else {
            $response = Http::withToken($token)->put($url, $data);
        }

        Log::info('API Response:', $response->json());

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'property' => $response->json()['data'],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update property',
            ]);
        }
    }

    public function destroy($id)
    {
        $token = session('token');
        $url = env('API_URL') . '/api/property/' . $id;

        $response = Http::withToken($token)->delete($url);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Property deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete property.',
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
        $url = env('API_URL') . '/api/units';
        $response = Http::withToken($token)->get($url);
        // dd($response->json());
        if ($response->successful()) {
            return view('dashboard.unit.index', [
                'title' => 'Unit',
                'units' => $response->json()['data'],
            ]);
        } else {
            return view('errors.api_error', [
                'message' => 'Failed to fetch categories from API',
            ]);
        }
    }

    public function CreateUnit()
    {
        $breadcrumbTitle = 'Create Unit';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/units';
        $urlProperty = env('API_URL') . '/api/property';
        $response = Http::withToken($token)->get($url);
        $responseProperty = Http::withToken($token)->get($urlProperty);
        // dd($response->json());
        // dd($responseProperty->json()['data']);
        if ($response->successful()) {
            return view('dashboard.unit.create', [
                'title' => 'Unit',
                'properties' => $responseProperty->json()['data'],
            ]);
        } else {
            return view('errors.api_error', [
                'message' => 'Failed to fetch categories from API',
            ]);
        }
    }

    public function editUnit($id)
    {
        $breadcrumbTitle = 'Create Unit';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/units/' . $id;
        $urlProperty = env('API_URL') . '/api/property';
        $responseProperty = Http::withToken($token)->get($urlProperty);
        $response = Http::withToken($token)->get($url);
        // dd($responseProperty->json()['data']);
        // dd($response->json()['data']);
        if ($response->successful()) {
            return view('dashboard.unit.edit', [
                'title' => 'Edit Unit',
                'property' => $responseProperty->json()['data'],
                'units' => $response->json()['data']
            ]);
        }
    }

    public function StoreUnit(Request $request)
    {
        // dd($request->all());

        $validated = $request->validate([
            'property_id' => 'required|integer',
            'tipe' => 'required|string',
            'deskripsi' => 'required|string',
            'harga_unit' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/units';

        // Prepare request data
        $data = [
            'property_id' => $validated['property_id'],
            'tipe' => $validated['tipe'],
            'deskripsi' => $validated['deskripsi'],
            'harga_unit' => $validated['harga_unit'],
            'jumlah_kamar' => $validated['jumlah_kamar'],
        ];

        $requestObj = Http::withToken($token);

        foreach ($request->file('images') as $image) {
            $requestObj->attach('images[]', fopen($image->getRealPath(), 'r'), $image->getClientOriginalName());
        }

        $response = $requestObj->post($url, $data);

        $responseData = $response->json();
        if ($responseData !== null) {
            Log::info('API Response:', $responseData);
        } else {
            Log::info('API Response is null.');
        }

        if ($response->successful()) {
            Log::info('API Response Successful', $responseData['data'] ?? []);
            return response()->json([
                'success' => true,
                'unit' => $responseData['data'] ?? [],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add unit',
            ]);
        }
    }

    public function updateUnit(Request $request, $id)
    {
        dd($request->all());
        $validated = $request->validate([
            'property_id' => 'required|integer',
            'tipe' => 'required|string',
            'deskripsi' => 'required|string',
            'harga_unit' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }
}
