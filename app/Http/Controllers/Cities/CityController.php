<?php

declare(strict_types=1);

namespace App\Http\Controllers\Cities;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cities\StoreRequest;
use App\Models\Cities\City;
use App\Services\Cities\CityService as Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CityController extends Controller
{
    protected string $templatePath = 'admin.cities.';

    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->storeElement($request->validated());
        return redirect()->route('cities.index');
    }

    public function edit(City $city): View
    {
        return $this->editElement($city);
    }

    public function update(StoreRequest $request, City $city): RedirectResponse
    {
        return $this->updateElement($request->validated(), $city);
    }

    public function destroy(City $city): JsonResponse
    {
        $city->delete();
        $response['success'] = 'OK';
        return response()->json($response);
    }

}
