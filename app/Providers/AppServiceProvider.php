<?php

namespace App\Providers;

use App\Models\Idea;
use App\Models\User;
use App\Observers\IdeaObserver;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;

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

        Feature::define('reactions', fn (?User $user) => false);
    }
}
