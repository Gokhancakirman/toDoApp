<?php

namespace App\Services\Provider;

use Illuminate\Support\Arr;

class ProviderManager
{
    public static function createProviderService($url, $providerName, $parameters) : ProviderService
    {
        $service = new ProviderService($url, $providerName, $parameters);
        $service->getProviders();
        return  $service;
    }
}
