<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeatherResource;
use App\Models\Cities\City;

class WeatherController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return WeatherResource::collection($cities);
    }
}
