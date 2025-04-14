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
        return []; // Hiện tại không có quy tắc vì không có input
    }
}