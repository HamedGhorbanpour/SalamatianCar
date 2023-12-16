<?php

namespace App\Http\Requests\Percent;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePercentRequest extends FormRequest
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
            'benefit' => 'filled|numeric|between:0,100' ,
            'tax' => 'filled|numeric|between:0,100' ,
        ];
    }
}
