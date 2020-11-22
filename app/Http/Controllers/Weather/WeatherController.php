<?php

declare(strict_types=1);

namespace App\Http\Controllers\Weather;

use App\Http\Controllers\Controller;
use App\Models\Cities\City;
use App\Services\Weather\WeatherService as Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WeatherController extends Controller
{
    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    /**
     * @param City $city
     * @return Application|ResponseFactory|JsonResponse|Response
     */
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
