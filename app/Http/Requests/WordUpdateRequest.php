<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WordUpdateRequest extends FormRequest
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
            'id_word' => 'required|integer',
            'word' => 'required|string|max:255',
            'image' => 'url|not_in:""', // Không cho phép giá trị rỗng
            'sound' => 'url|not_in:""', // Không cho phép giá trị rỗng
        ];
    }
    public function messages()
    {
        return [
            'id_word.required' => 'ID từ là bắt buộc.',
            'id_word.integer' => 'ID từ phải là một số nguyên.',
            'word.required' => 'Từ là bắt buộc.',
            'word.string' => 'Từ phải là chuỗi ký tự.',
            'word.max' => 'Từ không được vượt quá 255 ký tự.',
    
            'image.not_in' => 'Hình ảnh không được để trống.',
            'sound.not_in' => 'Âm thanh không được để trống.',
            'image.url' => 'Hình ảnh phải là một URL hợp lệ.',
            'sound.url' => 'Âm thanh phải là một URL hợp lệ.',
        ];
    }
}
