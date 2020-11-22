<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\WeatherResource;
use App\Models\Cities\City;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;

class WeatherController extends Controller
{
    /**
     * @return Application|Factory|JsonResponse|AnonymousResourceCollection|View
     */
    public function index()
    {
        $cities = City::all();
        return WeatherResource::collection($cities);
    }
}
