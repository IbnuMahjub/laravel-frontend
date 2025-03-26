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
        $urlCategory = env('API_URL') . '/api/valueCategory';

        try {
            $response = Http::withToken($token)->get($url);
            $category_id = Http::withToken($token)->get($urlCategory);
            // dd($response->json());
            // dd($category_id->json());
            if ($response->successful()) {
                return view('dashboard.property.index', [
                    'title' => 'Property',
                    'categories' => $category_id->json()['data'],
                    'properties' => $response->json()['data'],
                ]);
            }
        } catch (\Exception $e) {
            Session::forget('token');
            return redirect('/login')->with('error', 'Maaf, terjadi gangguan API. Silahkan mohon menunggu.');
        }
    }


    public function showProperty($slug)
    {
        $breadcrumbTitle = 'Detail Property';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);
        $token = session('token');
        $url = env('API_URL') . '/api/property/' . $slug;
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
            'name_property' => 'required|string',
            'alamat' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'negara' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',

        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/property';

        $response = Http::withToken($token)
            ->attach('image', fopen($request->file('image')->getRealPath(), 'r'), $request->file('image')->getClientOriginalName())
            ->post($url, [
                'name_property' => $validated['name_property'],
                'alamat' => $validated['alamat'],
                'negara' => $validated['negara'],
                'kota' => $validated['kota'],
                'kecamatan' => $validated['kecamatan'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
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
            'name_property' => 'required|string',
            'alamat' => 'required|string',
            'category_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/property/' . $id;

        $data = [
            'name_property' => $validated['name_property'],
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
            session()->flash('success', 'Property updated successfully.');
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

    public function TambahUnit()
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
        // dd($responseProperty->json()['data']);s
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
        $breadcrumbTitle = 'Ubah Unit';
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

        $validated = $request->validate(
            [
                'property_id' => 'required|integer',
                'tipe' => 'required|string',
                'deskripsi' => 'required|string',
                'harga_unit' => 'required|integer',
                'jumlah_kamar' => 'required|integer',
                'images' => 'required|array|min:2',
            ],
            [
                'images.array' => 'Image harus berupa array',
                'images.min' => 'Image harus memiliki minimal 2 gambar',
            ]
        );

        $token = session('token');
        $url = env('API_URL') . '/api/units';

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
            session()->flash('success', 'Unit berhasil Ditambahkan!');
            return redirect('/unit')->with('success', 'Unit berhasil Ditambahkan!');
        } else {
            return redirect('/unit')->with('error', 'Unit gagal ditambahkan!');
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Failed to add unit',
            // ]);
        }
    }

    public function updateUnit(Request $request, $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            'property_id' => 'required|integer',
            'tipe' => 'required|string',
            'deskripsi' => 'required|string',
            'harga_unit' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'images.*' => 'string|nullable',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/units/' . $id;
        // Prepare request data
        $data = [
            'property_id' => $validated['property_id'],
            'tipe' => $validated['tipe'],
            'deskripsi' => $validated['deskripsi'],
            'harga_unit' => $validated['harga_unit'],
            'jumlah_kamar' => $validated['jumlah_kamar'],
            '_method' => 'PUT',
        ];

        $requestObj = Http::withToken($token);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $requestObj->attach('images[]', fopen($image->getRealPath(), 'r'), $image->getClientOriginalName());
            }
        }


        $response = $requestObj->post($url, $data);

        $responseData = $response->json();
        if ($responseData !== null) {
            Log::info('API Response:', $responseData);
        } else {
            Log::info('API Response is null.');
        }

        // Handle the response
        if ($response->successful()) {
            return redirect('/unit')->with('success', 'Unit berhasil Diupdate!');
        } else {
            return redirect('/unit')->with('error', 'Unit gagal diupdate!');
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Failed to update unit',
            // ]);
        }
    }
    public function destroyUnit($id)
    {
        $token = session('token');
        $url = env('API_URL') . '/api/units/' . $id;

        $response = Http::withToken($token)->delete($url);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Unit deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete unit.',
            ]);
        }
    }
}
