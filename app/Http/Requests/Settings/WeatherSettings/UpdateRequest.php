<?php

declare(strict_types=1);

namespace App\Http\Requests\Settings\WeatherSettings;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'api_key' => 'required|string|max:255',
            'schedule_time' => 'nullable|date_format:H:i'
        ];
    }
}
