<?php

namespace App\Providers;

use App\Models\Idea;
use App\Models\SignInCode;
use App\Observers\IdeaObserver;
use App\Observers\SignInCodeObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

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
        JsonResource::withoutWrapping();

        Idea::observe(IdeaObserver::class);
        SignInCode::observe(SignInCodeObserver::class);
    }
}
