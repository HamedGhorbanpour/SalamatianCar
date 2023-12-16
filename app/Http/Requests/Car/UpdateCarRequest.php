<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model' => 'filled|string|max:250' ,
            'price' => 'filled|numeric' ,
            'lowest_down_payment' => 'filled|numeric|between:0,100' ,
            'brand_id' => 'filled|integer|exists:brands,id' ,
            'exist' => 'boolean'
        ];
    }
}
