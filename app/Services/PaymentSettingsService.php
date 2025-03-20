<?php

namespace App\Services;

use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Cache;

class PaymentSettingsService {

    function getSettings() {
        return Cache::rememberForever('paymentSettings', function(){
            return PaymentSetting::pluck('value', 'key')->toArray(); // ['key' => 'value']
        });
    }

    function setGlobalSettings() : void {
        $settings = $this->getSettings();
        config()->set('paymentSettings', $settings);
    }

    function clearCachedSettings() : void {
        Cache::forget('paymentSettings');
    }
}
