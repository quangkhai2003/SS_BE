<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateWordInDictionaryRequest extends FormRequest
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
            'dictionary_id' => 'required|integer',
            'word' => 'required|string|max:255',
            'ipa' => 'required|string|max:255',
            'word_type' => 'required|string|max:50',
            'vietnamese' => 'required|string|max:255',
            'examples' => 'nullable|string',
            'examples_vietnamese' => 'nullable|string',
            'topic' => 'required|string|max:100',
        ];
    }
    public function messages()
    {
        return [
            'dictionary_id.required' => 'ID từ điển là bắt buộc.',
            'dictionary_id.integer' => 'ID từ điển phải là một số nguyên.',
            'word.required' => 'Từ là bắt buộc.',
            'word.string' => 'Từ phải là chuỗi ký tự.',
            'word.max' => 'Từ không được vượt quá 255 ký tự.',
            'ipa.string' => 'IPA phải là chuỗi ký tự.',
            'ipa.max' => 'IPA không được vượt quá 255 ký tự.',
            'ipa.required' => 'IPA là bắt buộc.',
            'word_type.required' => 'Loại từ là bắt buộc.',
            'word_type.string' => 'Loại từ phải là chuỗi ký tự.',
            'word_type.max' => 'Loại từ không được vượt quá 50 ký tự.',
            'vietnamese.string' => 'Dịch nghĩa tiếng Việt phải là chuỗi ký tự.',
            'vietnamese.max' => 'Dịch nghĩa tiếng Việt không được vượt quá 255 ký tự.',
            'vietnamese.required' => 'Dịch nghĩa tiếng Việt là bắt buộc.',
            'topic.required' => 'Chủ đề là bắt buộc.',
            'topic.string' => 'Chủ đề phải là chuỗi ký tự.',
            'topic.max' => 'Chủ đề không được vượt quá 100 ký tự.',
            'examples.string' => 'Ví dụ phải là chuỗi ký tự.',
            // Thêm các thông báo lỗi khác nếu cần
        ];
    }
}
