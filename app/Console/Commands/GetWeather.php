<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Cities\City;
use App\Services\Weather\WeatherService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение погоды для всех гордов';

    protected WeatherService $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = app(WeatherService::class);
    }

    public function handle():bool
    {
        foreach ($this->getCities() as $city) {
            try {
                echo 'Получаю информацию о погоде города' . $city->name.PHP_EOL;
                $city->update(['weather_info' => $this->service->getByName($city->name)->getContents()]);
            } catch (GuzzleException $error) {
                echo 'Ошибка при получении информации о погоде города' . $city->name.PHP_EOL;
                Log::error($error->getMessage());
            }
        }

        echo 'complete';
        return true;
    }

    public function getCities()
    {
        return City::get();
    }
}
