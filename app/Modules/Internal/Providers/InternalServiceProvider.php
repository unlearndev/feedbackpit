<?php

namespace App\Modules\Internal\Providers;

use Illuminate\Support\ServiceProvider;

class InternalServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
    }
}
