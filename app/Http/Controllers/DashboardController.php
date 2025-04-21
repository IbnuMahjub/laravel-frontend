<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\OrderNotification;
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
        $token = session('token');
        $url = env('API_URL') . '/api/countOrder';
        $response = Http::withToken($token)->get($url);
        $data = $response->json();
        // dd($response->json());       

        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Analysis', 'url' => 'javascript:;', 'active' => true],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbsTitle = 'Dashboard');
        return view('dashboard.index', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            // 'orders' => $data['dataorder'],
            // 'orderCount' => $data['count'],
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
        // dd($category_id->json());
        return view('dashboard.test', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'categories' => $category_id->json(),
            'properties' => $response->json()['data'],

        ]);
    }

    public function storeTest(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string',
            'alamat' => 'required|string',
            'property_id' => 'required|integer',
            'harga' => 'required|numeric',
            'image' => 'required|array|min:3',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Name is harus diisi',
            'alamat.required' => 'Alamat is harus diisi',
            'property_id.required' => 'Property ID is harus diisi',
            'harga.required' => 'Harga is harus diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'image.required' => 'Image is harus diisi',
            'image.array' => 'Image harus berupa array',
            'image.min' => 'Image harus memiliki minimal 3 gambar',
        ]);
    }

    public function fetchNotifications()
    {
        $token = session('token');
        $url = env('API_URL') . '/api/countOrder';
        $response = Http::withToken($token)->get($url);
        $data = $response->json();

        // Ubah waktu jadi "x minutes ago"
        foreach ($data['dataorder'] as &$order) {
            $order['waktu_pemesanan_human'] = \Carbon\Carbon::parse($order['waktu_pemesanan'])->diffForHumans();
        }

        return response()->json($data);
    }

    public function sendNotif()
    {
        broadcast(new OrderNotification("Notifikasi dari sistem!"));

        return response()->json(['message' => 'Broadcast sent']);
    }

    public function socket()
    {
        $breadcrumbs = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Analysis', 'url' => 'javascript:;', 'active' => true],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbsTitle = 'Dashboard');
        return view('dashboard.socket', [
            'title' => 'Dashboard',
        ]);
    }
}
