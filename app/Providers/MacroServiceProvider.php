<?php

namespace App\Providers;

use App\Macros\ResponseMacro;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Response::mixin(new ResponseMacro());
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
