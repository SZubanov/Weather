<?php

declare(strict_types=1);

namespace App\Services\Cities;


use App\Models\Cities\City;
use App\Services\ModelService;
use Illuminate\Http\JsonResponse;

class CityService extends ModelService
{
    protected string $translate = 'cities';

    public function __construct()
    {
        parent::__construct(app(City::class));
    }

    public function getDataForIndex(): array
    {
        return [
            'columns' => $this->getColumns(),
            'jsonColumns' => $this->getJsonColumns(),
        ];
    }

    public function getDataForCreate(): array
    {
        return array_merge([
            'formRoute' => route('cities.store')
        ]);
    }

    public function getDataForEdit(City $city): array
    {
        return array_merge([
            'formMethod' => 'PUT',
            'formRoute' => route('cities.update', $city),
            'city' => $city,
        ]);
    }

    public function getColumns(): array
    {
        $columns = [
            [
                'data' => 'id',
            ],
            [
                'data' => 'name',
            ],
            [
                'data' => 'weather_info',
                'sortable' => false,
                'searchable' => false,
            ],
            [
                'data' => 'action',
                'sortable' => false,
                'searchable' => false,
            ],
        ];

        return $this->addCaptionForColumns($columns);
    }

    public function getObjectsForTable(array $params = []): JsonResponse
    {
        $query = $this->queryForTable($params);
        return $this->makeDatatable($query)
            ->addColumn('action', fn($city) => view('admin.cities.datatable.action', ['city' => $city]))
            ->addColumn('weather_info', function ($city) {
                if (!is_null($city->weather_info)) {
                    $weather = json_decode($city->weather_info);
                    $weather = round($weather->main->temp - 273.15, 0);
                    return $weather . ' °C';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function parseCities()
    {
        $fileContent = file_get_contents(public_path().'/city.list.json');
        dd($fileContent);
    }
}
