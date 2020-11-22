<?php

declare(strict_types=1);

namespace App\Services\Settings;


use App\Models\Settings\WeatherSettings;
use App\Services\ModelService;

class WeatherSettingService extends ModelService
{
    protected string $translate = 'settings.weather';

    public function __construct()
    {
        parent::__construct(app(WeatherSettings::class));
    }

    public function getDataForIndex(): array
    {
        $settings = WeatherSettings::first();
        return array_merge([
            'formMethod' => 'PUT',
            'formRoute' => route('settings.weather.update', $settings),
            'settings' => $settings
        ]);
    }
}
