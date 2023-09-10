// src/OrangeSmsServiceProvider.php

namespace OrangeSms;

use Illuminate\Support\ServiceProvider;

class OrangeSmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OrangeSms::class, function ($app) {
            return new OrangeSms(
                config('orange-sms.api_url'),
                config('orange-sms.token')
            );
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/orange-sms.php' => config_path('orange-sms.php'),
        ], 'config');
    }
}
