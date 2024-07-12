<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryPostRequest extends FormRequest
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
        $cate_post_id = $this->route('cate_post_id');
        return [
            'cate_post_name' => [
                'required',
                'max:50',
                Rule::unique('tbl_category_post', 'cate_post_name')->ignore($cate_post_id, 'cate_post_id'),
            ],
            'cate_post_desc' => 'nullable|max:500',
            'cate_post_status' => 'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'cate_post_name.required' => 'Tên danh mục là bắt buộc.',
            'cate_post_name.max' => 'Tên danh mục không được vượt quá :max ký tự.',
            'cate_post_desc.max' => 'Mô tả không được vượt quá :max ký tự.',
            'cate_post_name.unique' => 'Tên danh mục đã tồn tại.',
            'cate_post_status.required' => 'Trạng thái là bắt buộc.',
            'cate_post_status.boolean' => 'Trạng thái phải là hiển thị hoặc ẩn.',
        ];
    }
}
