<?php

declare(strict_types=1);

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Models\Cities\City;
use App\Services\Weather\WeatherService as Service;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    public function getWeatherCity(City $city)
    {
        try {
            $city->update(['weather_info' => $this->service->getByName($city->name)->getContents()]);
            return response()->json([
                'action'  => 'success',
            ]);
        } catch (\Exception $error) {
            return response('Ошибка при получении данных', 404);
        }
    }
}
