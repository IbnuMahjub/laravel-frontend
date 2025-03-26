<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function storeBooking(Request $request)
    {
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

        try {
            $url = env('API_URL') . '/api/booking';
            $response = Http::post($url, $validated);

            if ($response->successful()) {
                $responseData = $response->json();
                $kode_pemesanan = $responseData['data']['kode_pemesanan'] ?? null;

                if ($kode_pemesanan) {
                    return redirect()->route('booking.detail', ['kode_pemesanan' => $kode_pemesanan]);
                }
                return back()->with('error', 'Kode pemesanan tidak ditemukan.');
            }

            return back()->with('error', $response->json()['message'] ?? 'Gagal membuat booking.');
        } catch (\Exception $e) {
            Log::error('Error in storeBooking: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan, coba lagi nanti.');
        }
    }

    public function get_data_booking($kode_pemesanan)
    {
        try {
            $url = env('API_URL') . '/api/booking/' . $kode_pemesanan;
            $response = Http::get($url);

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data booking.');
            }

            $data = $response->json()['data'] ?? null;

            if (!$data || !isset($data['total_harga'])) {
                return back()->with('error', 'Data booking tidak valid.');
            }

            // Konfigurasi Midtrans
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = config('midtrans.is_production');
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $transaction = [
                'transaction_details' => [
                    'order_id' => $data['kode_pemesanan'],
                    'gross_amount' => (int) $data['total_harga'],
                ],
                'customer_details' => [
                    'first_name' => $data['username'] ?? 'Guest',
                    'email' => ($data['username'] ?? 'guest') . '@example.com',
                ]
            ];

            $snapToken = Snap::getSnapToken($transaction);

            return view('payment', [
                'title' => 'Pembayaran',
                'data' => $data,
                'snapToken' => $snapToken
            ]);
        } catch (\Exception $e) {
            Log::error('Error in get_data_booking: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran.');
        }
    }

    public function get_invoice($kode_pemesanan)
    {
        try {
            $url = env('API_URL') . '/api/booking/' . $kode_pemesanan;
            $response = Http::get($url);

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data booking.');
            }

            $data = $response->json()['data'] ?? null;

            // dd($data);
            if (!$data || !isset($data['total_harga'])) {
                return back()->with('error', 'Data booking tidak valid.');
            }

            return view('invoice', [
                'title' => 'Invoice',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Error in get_invoice: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran.');
        }
    }
}
