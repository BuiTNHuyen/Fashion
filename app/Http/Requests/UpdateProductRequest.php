<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    { 
        return [
            'brand_id' => 'required|integer',
            'origin_id' => 'required|integer',
            'category_id' => 'required|integer',
            'name' => 'required|string',
            'initial_price' => 'required|numeric',
            'discount' => 'nullable|integer|between:0,100',
            'quantity' => 'required|numeric',
            'description' =>'required|string',
            'images.*' => 'mimes:jpg,bmp,png,webp'
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required' => 'Vui lòng chọn tên thương hiệu.', 
            'origin_id.required' => 'Vui lòng chọn tên nơi sản xuất.', 
            'category_id.required' => 'Vui lòng chọn tên danh mục.', 
            'name.required' => 'Vui lòng nhập tên sách.',
            'initial_price.required' => 'Vui lòng nhập giá.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'description.required' => 'Vui lòng nhập mô tả.',
        ];
    }
}
