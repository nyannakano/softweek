<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'friday' => 'required',
            'monday1' => 'required',
            'monday2' => 'required',
            'tuesday1' => 'required',
            'tuesday2' => 'required',
            'wednesday1' => 'required',
            'wednesday2' => 'required',
            'thursday1' => 'required',
            'thursday2' => 'required',
            'lunch' => 'required_if:friday,yes',
            'drink' => 'required_if:friday,yes'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
