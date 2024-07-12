<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{

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
        $brand_id = $this->route('brand_id');
        return [
            'brand_product_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_brand', 'brand_name')->ignore($brand_id, 'brand_id'),
            ],
            'brand_product_desc' => 'nullable|max:500',
            'brand_product_status' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'brand_product_name.required' => 'Tên thương hiệu là bắt buộc.',
            'brand_product_name.max' => 'Tên thương hiệu không được vượt quá :max ký tự.',
            'brand_product_desc.max' => 'Mô tả không được vượt quá :max ký tự.',
            'brand_product_name.unique' => 'Tên thương hiệu đã tồn tại.',
            'brand_product_status.required' => 'Trạng thái thương hiệu là bắt buộc.',
            'brand_product_status.boolean' => 'Trạng thái thương hiệu phải là hiển thị hoặc ẩn.',
        ];
    }
}
