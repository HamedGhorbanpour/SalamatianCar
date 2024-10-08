<?php

namespace App\Http\Requests\Car;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarRequest extends FormRequest
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
            'model' => 'required|string|unique:cars|max:250' ,
            'price' => 'required|numeric' ,
            'lowest_down_payment' => 'required|numeric|between:0,100' ,
            'brand_id' => 'required|integer|exists:brands,id' ,
            'user_id' => 'integer|exists:users,id' ,
        ];
    }
}
