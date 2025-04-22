<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgressRequest extends FormRequest
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
            'topic_name' => 'required|string|max:255|unique:progress_through_level,topic_name',
        ];
    }
    public function messages()
    {
        return [
            'topic_name.required' => 'Chủ đề là bắt buộc.',
            'topic_name.string' => 'Chủ đề phải là chuỗi ký tự.',
            'topic_name.max' => 'Chủ đề không được vượt quá 255 ký tự.',
            'topic_name.unique' => 'Chủ đề đã tồn tại.',
        ];
    }
}
