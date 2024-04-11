<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        // Code...
        Validator::extend('godFilter', function ($attribute, $value) {
            if (preg_match('/\bgod\b/i', $value)) {
                return false;
            }
            return true;
        }, 'God filter works...!');

        Paginator::useBootstrap();
        JsonResource::withoutWrapping();
    }
}
