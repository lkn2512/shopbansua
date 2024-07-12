<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryProductRequest extends FormRequest
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
        $category_id = $this->route('category_id');
        return [
            'category_product_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_category_product', 'category_name')->ignore($category_id, 'category_id'),
            ],
            'category_product_desc' => 'nullable|max:500',
            'category_product_status' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'category_product_name.required' => 'Tên danh mục là bắt buộc.',
            'category_product_name.max' => 'Tên danh mục không được vượt quá :max ký tự.',
            'category_product_desc.max' => 'Mô tả không được vượt quá :max ký tự.',
            'category_product_name.unique' => 'Tên danh mục đã tồn tại.',
            'category_product_status.required' => 'Trạng thái là bắt buộc.',
            'category_product_status.boolean' => 'Trạng thái phải là hiển thị hoặc ẩn.',
        ];
    }
}
