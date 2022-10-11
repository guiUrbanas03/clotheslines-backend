<?php

namespace App\Providers;

use App\Enums\HearteableType;
use App\Services\Heart\HeartService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HeartService::class, function () {

            $hearteable = (object) [
                'id' => request()->hearteable_id,
                'type' => HearteableType::MODEL[request()->hearteable_type]
            ];

            return new HeartService($hearteable);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
