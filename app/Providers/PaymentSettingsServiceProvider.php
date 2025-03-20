<?php

namespace App\Providers;

use App\Services\PaymentSettingsService;
use Illuminate\Support\ServiceProvider;

class PaymentSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentSettingsService::class, function(){
            return new PaymentSettingsService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $paymentSetting=$this->app->make(PaymentSettingsService::class);
        $paymentSetting->setGlobalSettings();
    }
}
