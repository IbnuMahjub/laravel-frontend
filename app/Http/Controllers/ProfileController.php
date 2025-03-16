<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function profile()
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
                return view('dashboard.profile.index', [
                    'title' => 'Profile',

                ]);
            }
        } catch (\Exception $e) {
            Session::forget('token');
            return redirect('/login')->with('error', 'Maaf, terjadi gangguan API. Silahkan mohon menunggu.');
        }
    }

    public function updateProfile(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string',
            'username' => 'required|string',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        Log::debug('Data being sent to API:', [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'avatar' => $request->hasFile('avatar') ? 'avatar file present' : 'no avatar',
        ]);

        $token = session('token');
        $url = env('API_URL') . '/api/profile';

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            '_method' => 'PUT',
        ];

        if ($request->hasFile('avatar')) {
            $response = Http::withToken($token)
                ->attach('avatar', fopen($request->file('avatar')->getRealPath(), 'r'), $request->file('avatar')->getClientOriginalName())
                ->post($url, $data);
        } else {
            $response = Http::withToken($token)->put($url, $data);
        }
        Log::debug('API Response:', ['response' => $response->json()]);

        if ($response->successful()) {
            session(['user' => $response->json()['data']]);

            return redirect('/profile')->with('success', 'Profile updated successfully.');
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile',
            ]);
        }
    }
}
