<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function index()
    {
        return view('login', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $url = env('API_URL') . '/api/login';

        try {
            // Mengirimkan permintaan POST ke API login
            $response = Http::post($url, [
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            if ($response->status() === 401) {
                $errorMessage = $response->json()['message'] ?? 'Login failed. Please check your credentials.';
                return back()->with('loginError', $errorMessage);
            }

            if ($response->successful()) {
                $data = $response->json();

                Session::put('token', $data['token']);
                Session::put('user', $data['user']);

                return redirect('/dashboard');
            }

            return back()->with('loginError', 'An unknown error occurred. Please try again.');
        } catch (\Exception $e) {
            return back()->with('loginError', 'Maaf Sedang Ada gangguan');
        }
    }



    public function logout()
    {
        Session::forget('token');
        Session::forget('user');

        return redirect()->route('login');
    }

    

    /**
     * Display the reset password page.
     *
     * @return \Illuminate\Http\Response
     */
    public function v_resetpassword()
    {
        return view('reset', [
            'title' => 'Reset Password',
            'active' => 'reset-password'
        ]);
    }

    // ini untuk jika sudah berhasil reset password
    public function getTokenEmail(Request $request)
    {
        $token = $request->query('token');
        return view('form_reset', [
            'title' => 'Login',
            'active' => 'login',
            'token' => $token
        ]);
    }

    public function resetPassword(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'password_confirmation' => 'required|string|same:password',
        ]);

        $url = env('API_URL') . '/api/reset-password';
        $response = Http::post($url, [
            'email' => $validated['email'],
            'password' => $validated['password'],
            'password_confirmation' => $validated['password_confirmation'],
            'token' => $request->token
        ]);

        try {
            if ($response->successful()) {
                $data = $response->json();
                return redirect('/login')->with('success', $data['message']);
            }
            return back()->with('loginError', 'An unknown error occurred. Please try again.');
        } catch (\Throwable $th) {
                return redirect('/login');
            }
        
    }

    public function sendEmail(Request $request)
    {
        $email = $request->email;

        $url = env('API_URL') . '/api/forgot-password';
        $response = Http::post($url, ['email' => $email]);
        try {
            if ($response->successful()) {
                $data = $response->json();
                return redirect('/lupa-password')->with('success', $data['message']);
            }
            return back()->with('loginError', 'An unknown error occurred. Please try again.');
        } catch (\Throwable $th) {
            return back()->with('loginError', 'Maaf Sedang Ada gangguan');
        }
        
    }
}
