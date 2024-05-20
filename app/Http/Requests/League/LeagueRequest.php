<?php

namespace App\Http\Requests\League;

use Illuminate\Foundation\Http\FormRequest;


class LeagueRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'form_data.name' => 'required|string|min:5|max:50',
            'form_data.logo' => 'nullable|url|min:5|max:255',
            'form_data.description' => 'nullable|string|min:20|max:1000',
            'form_data.primary_color' => 'required|string|min:5|max:20',
            'form_data.secondary_color' => 'required|string|min:5|max:20',
        ];

        // Add subscription field rules only if 'subscription' key is present in the request
        if ($this->has('subscription')) {
            $rules['subscription.payment_method_id'] = 'required|string';
            $rules['subscription.product_id'] = 'required|string';
            $rules['subscription.price_id'] = 'required|string';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            // Messages for fields under 'form_data'
            'form_data.name.required' => 'The name field is required.',
            'form_data.name.string' => 'The name must be a string.',
            'form_data.name.min' => 'The name must be at least :min characters.',
            'form_data.name.max' => 'The name may not be greater than :max characters.',

            'form_data.logo.url' => 'The logo must be a valid URL.',
            'form_data.logo.min' => 'The logo must be at least :min characters.',
            'form_data.logo.max' => 'The logo may not be greater than :max characters.',

            'form_data.description.required' => 'The description field is required.',
            'form_data.description.string' => 'The description must be a string.',
            'form_data.description.min' => 'The description must be at least :min characters.',
            'form_data.description.max' => 'The description may not be greater than :max characters.',

            'form_data.primary_color.required' => 'The primary color field is required.',
            'form_data.primary_color.string' => 'The primary color must be a string.',
            'form_data.primary_color.min' => 'The primary color must be at least :min characters.',
            'form_data.primary_color.max' => 'The primary color may not be greater than :max characters.',

            'form_data.secondary_color.required' => 'The secondary color field is required.',
            'form_data.secondary_color.string' => 'The secondary color must be a string.',
            'form_data.secondary_color.min' => 'The secondary color must be at least :min characters.',
            'form_data.secondary_color.max' => 'The secondary color may not be greater than :max characters.',

            'form_data.owner_id.required' => 'The owner ID field is required.',
            'form_data.owner_id.exists' => 'Invalid owner ID.',

            'form_data.organization_id.nullable' => 'The organization ID field must be nullable.',

            // Messages for subscription fields
            'form_data.subscription.payment_method_id.required' => 'The payment method ID field is required.',
            'form_data.subscription.payment_method_id.string' => 'The payment method ID must be a string.',

            'subscription.league_id.required' => 'The league ID field is required.',
            'subscription.league_id.integer' => 'The league ID must be an integer.',
        ];
    }


    public function authorize(): bool
    {
        return true;
    }
}
