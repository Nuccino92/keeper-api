<?php

namespace App\Http\Requests\League;

use Illuminate\Foundation\Http\FormRequest;


class UpdateLeagueRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:5|max:50',
            'logo' => 'nullable|url|min:5|max:255',
            'description' => 'nullable|string|min:20|max:1000',
            'primary_color' => 'required|string|min:5|max:20',
            'secondary_color' => 'required|string|min:5|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least :min characters.',
            'name.max' => 'The name may not be greater than :max characters.',

            'logo.url' => 'The logo must be a valid URL.',
            'logo.min' => 'The logo must be at least :min characters.',
            'logo.max' => 'The logo may not be greater than :max characters.',

            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a string.',
            'description.min' => 'The description must be at least :min characters.',
            'description.max' => 'The description may not be greater than :max characters.',

            'primary_color.required' => 'The primary color field is required.',
            'primary_color.string' => 'The primary color must be a string.',
            'primary_color.min' => 'The primary color must be at least :min characters.',
            'primary_color.max' => 'The primary color may not be greater than :max characters.',

            'secondary_color.required' => 'The secondary color field is required.',
            'secondary_color.string' => 'The secondary color must be a string.',
            'secondary_color.min' => 'The secondary color must be at least :min characters.',
            'secondary_color.max' => 'The secondary color may not be greater than :max characters.',
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
