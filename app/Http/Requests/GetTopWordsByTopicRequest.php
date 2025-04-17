<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetTopWordsByTopicRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cho phép tất cả người dùng truy cập (có thể thêm logic xác thực sau)
    }

    public function rules()
    {
        return [
            'topic' => 'required|string|max:255', // Kiểm tra topic là chuỗi và không quá 255 ký tự
        ]; // Hiện tại không có quy tắc vì không có input
    }
    public function messages()
    {
        return [
            'topic.required' => 'The topic field is required.',
            'topic.string' => 'The topic must be a string.',
            'topic.max' => 'The topic may not be greater than 255 characters.',
        ];
    }
}