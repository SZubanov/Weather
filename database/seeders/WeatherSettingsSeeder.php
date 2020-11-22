<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Settings\WeatherSettings;
use Illuminate\Database\Seeder;

class WeatherSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        WeatherSettings::firstOrCreate([
            'api_key' => config('api.weather')
        ], [
                'schedule_time' => '00:00'
            ]
        );
    }
}
