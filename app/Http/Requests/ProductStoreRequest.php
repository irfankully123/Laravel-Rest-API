<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ProductStoreRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape([
            'name' => "string",
            'quantity' => "string",
            'brand' => "string",
            'model' => "string",
            'category' => "string",
            'stock' => "string",
            'price' => "string",
            'image_url' => "string"
    ])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:50|min:4',
            'quantity' => 'required|integer|numeric',
            'brand' => 'required|string|max:50|min:3',
            'model' => 'required|string|max:50|min:3',
            'category' => 'required|string|max:50|min:3',
            'stock' => 'required|in:instock,outofstock|string',
            'price' => 'required|numeric|between:0,9999999999.99',
            'image_url' => 'nullable'
        ];
    }
}
