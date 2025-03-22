<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class DataOrderController extends Controller
{
    public function index()
    {
        $breadcrumbTitle = 'List Data Order';
        $breadcrumbs = [
            ['title' => 'Data Property', 'url' => '/property'],
            ['title' => 'Data Unit', 'url' => '/unit'],
            ['title' => 'Data Order', 'url' => '/data_order'],
        ];
        $this->generateBreadcrumb($breadcrumbs, $breadcrumbTitle);

        $token = session('token');
        $url = env('API_URL') . '/api/data_orders';
        try {
            $response = Http::withToken($token)->get($url);
            // dd($response->json());
            if ($response->successful()) {
                return view('dashboard.data_order.index', [
                    'title' => 'Data Order',
                    'data_orders' => $response->json()['data'],
                ]);
            }
        } catch (\Throwable $th) {
            Session::forget('token');
            return redirect('/login')->with('error', 'Maaf, terjadi gangguan API. Silahkan mohon menunggu.');
        }
    }
}
