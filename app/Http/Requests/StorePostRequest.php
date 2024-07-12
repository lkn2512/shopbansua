<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
        $post_id = $this->route('post_id');
        return [
            'post_title' => [
                'required', 'max:60',
                Rule::unique('tbl_posts', 'post_title')->ignore($post_id, 'post_id'),
            ],
            'post_image' => [
                'image', 'mimes:jpeg,png,jpg,gif', 'max:10240',
                Rule::unique('tbl_posts', 'post_image')->ignore($post_id, 'post_id'),
            ],
            'post_desc' => 'required|max:250',
            'cate_post_id' => 'required',
            'post_status' => 'required|in:0,1',
            'post_content' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'post_title.required' => 'Tiêu đề tin tức là bắt buộc.',
            'post_title.max' => 'Tiêu đề tin tức không được vượt quá :max ký tự.',
            'post_title.unique' => 'Tiêu đề tin tức đã tồn tại.',
            'post_image.required' => 'Hình ảnh là bắt buộc.',
            'post_image.image' => 'Định dạng tập tin không hợp lệ.',
            'post_image.mimes' => 'Hình ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'post_image.max' => 'Hình ảnh không được vượt quá 10MB.',
            'post_desc.required' => 'Mô tả ngắn là bắt buộc.',
            'post_desc.max' => 'Mô tả ngắn không được vượt quá :max ký tự.',
            'cate_post_id.required' => 'Danh mục bài viết là bắt buộc.',
            'post_status.required' => 'Trạng thái là bắt buộc.',
            'post_status.in' => 'Trạng thái không hợp lệ.',
            'post_content.required' => 'Nội dung là bắt buộc.',
        ];
    }
}
