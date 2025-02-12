<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherFormRequest extends FormRequest
{
    /**
     * Determine if user is allowed
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * request rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'city' => 'required|string|max:255',
        ];
    }
}