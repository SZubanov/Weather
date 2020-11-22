<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\WeatherSettings\UpdateRequest;
use App\Models\Settings\WeatherSettings;
use App\Services\Settings\WeatherSettingService as Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class WeatherSettingController extends Controller
{
    protected string $templatePath = 'admin.settings.weather.';

    public function __construct(Service $service)
    {
        parent::__construct($service);
    }

    public function update(UpdateRequest $request, WeatherSettings $settings): RedirectResponse
    {
        return $this->updateElement($request->validated(), $settings);
    }
}
