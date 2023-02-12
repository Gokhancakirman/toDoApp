<?php

namespace App\Services\Provider;

use App\Models\Providers;
use Illuminate\Support\Facades\Http;

class ProviderService implements IProviderService
{
    private string $url;
    private array $tasks = [];
    private string $providerName;
    private string $parameters;

    public function __construct(string $url, string $providerName, string $parameters)
    {
        $this->url = $url;
        $this->providerName = $providerName;
        $this->parameters = $parameters;
    }

    public function getProviders()
    {
        $response = Http::get($this->url);
        $data = $response->json();
        $params = explode(',',$this->parameters);
        if($params[0] == "{key}")
        {
            foreach ($data as $value) {
                foreach ($value as $name => $val)
                {
                    $this->tasks [] = [
                        "name" => $name,
                        "difficulty" => $val[$params[1]],
                        "duration" => $val[$params[2]],
                        "provider" => $this->providerName
                    ];
                }
            }
        }
        else
        {
            foreach ($data as $value) {
                $this->tasks [] = [
                    "name" => $value[$params[0]],
                    "difficulty" => $value[$params[1]],
                    "duration" => $value[$params[2]],
                    "provider" => $this->providerName
                ];
            }
        }
    }

    public function saveProviders()
    {
        Providers::where('provider',$this->providerName)->delete();
        return Providers::insert($this->tasks);
    }
}
