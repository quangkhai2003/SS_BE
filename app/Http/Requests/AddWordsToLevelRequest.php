<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddWordsToLevelRequest extends FormRequest
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
            'id_level' => 'required|integer|exists:level,level_id',
            'words' => 'required|array',
            'words.*.word' => 'required|string|max:255',
            'words.*.image' => 'url|not_in:""', // Không cho phép giá trị rỗng
            'words.*.sound' => 'url|not_in:""', // Không cho phép giá trị rỗng
        ];
    }
    public function messages()
    {
        return [
            'level_id.required' => 'ID cấp độ là bắt buộc.',
            'level_id.integer' => 'ID cấp độ phải là một số nguyên.',
            'level_id.exists' => 'ID cấp độ không tồn tại.',
            'words.required' => 'Danh sách từ là bắt buộc.',
            'words.array' => 'Danh sách từ phải là một mảng.',
            'words.*.word.required' => 'Từ là bắt buộc.',
            'words.*.word.string' => 'Từ phải là chuỗi ký tự.',
            'words.*.word.max' => 'Từ không được vượt quá 255 ký tự.',
            'words.*.image.not_in' => 'Hình ảnh không được để trống.',
            'words.*.sound.not_in' => 'Âm thanh không được để trống.',
            'words.*.image.url' => 'Hình ảnh phải là một URL hợp lệ.',
            'words.*.sound.url' => 'Âm thanh phải là một URL hợp lệ.',
        ];
    }
}
