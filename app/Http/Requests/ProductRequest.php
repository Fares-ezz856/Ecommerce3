<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required',
            'description'=>'required',
            'price'=>'required|numeric',
            'stock_quantity'=>'required|integer',
            'image'=>'nullable|image',
            'category_id'=>'required|exists:categories,id'
        ];
    }
}
