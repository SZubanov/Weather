<?php

declare(strict_types=1);

namespace App\Models\Settings;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeatherSettings extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    public function getScheduleTimeAttribute($time): string
    {
        return $time ? Carbon::parse($time)->format('H:i') : '';
    }
}
