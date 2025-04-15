<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DictionaryRequest extends FormRequest
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
            'topic' => 'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'topic.required' => 'Chủ đề là bắt buộc.',
            'topic.string' => 'Chủ đề phải là chuỗi ký tự.',
            'topic.max' => 'Chủ đề không được vượt quá 255 ký tự.',
        ];
    }
}
