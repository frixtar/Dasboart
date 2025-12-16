<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
    use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

public function boot(): void
{
    // Forzamos HTTPS para que los estilos carguen bien en Ngrok
    if ($this->app->environment('production') || !empty($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
        URL::forceScheme('https');
    }
}
}
