<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
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
        Response::macro('caps', function ($value) {
            return Response::make(strtoupper($value));
        });

        Http::macro('stripe', function () {
            return Http::withToken(config('app.stripe_secret_key'))->baseUrl('https://api.stripe.com/v1')->asForm();
        });
    }
}
