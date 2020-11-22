<?php

declare(strict_types=1);

namespace App\Services\Weather;


use App\Models\Settings\WeatherSettings;
use App\Services\Service;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

class WeatherService extends Service
{
    const URL = 'api.openweathermap.org/data/2.5/weather';

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function request(array $queryParams): StreamInterface
    {
        return $this->client->get(self::URL."?".$this->setQuery($queryParams))->getBody();
    }

    protected function setQuery(array $queryParams): string
    {
        return http_build_query(array_merge($this->getToken(), $queryParams));
    }

    public function getToken(): array
    {
        return [
            'APPID' =>  WeatherSettings::value('api_key') ?? config('api.weather')
        ];
    }

    public function getByName(string $city): StreamInterface
    {
        return $this->request(['q' => $city]);
    }
}
