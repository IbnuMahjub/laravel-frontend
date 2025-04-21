<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('dashboard.layouts.main', function ($view) {
            $token = session('token');

            if ($token) {
                try {
                    $url = env('API_URL') . '/api/countOrder';
                    $response = Http::withToken($token)->get($url);

                    // dd($response->json());
                    if ($response->successful()) {
                        $data = $response->json();

                        $view->with([
                            'orders' => $data['dataorder'] ?? [],
                            'orderCount' => $data['count'] ?? 0,
                        ]);
                    } else {
                        $view->with([
                            'orders' => [],
                            'orderCount' => 0,
                        ]);
                    }
                } catch (\Exception $e) {
                    Session::forget('token');
                    $view->with([
                        'orders' => [],
                        'orderCount' => 0,
                    ]);
                }
            } else {
                $view->with([
                    'orders' => [],
                    'orderCount' => 0,
                ]);
            }
        });
    }
}
