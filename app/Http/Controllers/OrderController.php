<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{

    public function storeBooking(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'property_id' => 'required|integer',
            'unit_id' => 'required|integer',
            'name_property' => 'required|string',
            'harga_unit' => 'required|integer',
            'jumlah_kamar' => 'required|integer',
            'user_id' => 'nullable|integer',
            'username' => 'nullable|string',
            'catatan' => 'nullable|string',
            'tanggal_check_in' => 'required|date',
            'tanggal_check_out' => 'required|date',
            'jumlah_hari' => 'required|integer',
        ]);

        $url = env('API_URL') . '/api/booking';
        $response = Http::post($url, $validated);

        $responseData = $response->json();

        if ($response->successful()) {
            $kode_pemesanan = $responseData['data']['kode_pemesanan'] ?? null;

            if ($kode_pemesanan) {
                return redirect()->route('booking.detail', ['kode_pemesanan' => $kode_pemesanan]);
            }

            return back()->with('error', 'Kode pemesanan tidak ditemukan.');
        }

        // Jika gagal, kembalikan error
        return back()->withErrors([
            'message' => $responseData['message'] ?? 'Gagal membuat booking.',
            'errors' => $responseData['errors'] ?? null,
        ]);
    }

    public function get_data_booking($kode_pemesanan)
    {
        $url = env('API_URL') . '/api/booking/' . $kode_pemesanan;
        $response = Http::get($url);
        // dd($response->json()['data']);

        if ($response->successful()) {
            return view('payment', [
                'data' => $response->json()['data']
            ]);
            // return response()->json([
            //     'success' => true,
            //     'data' => $response->json()['data'],
            // ]);
        }
    }
}
