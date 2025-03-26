<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoadMapRequest extends FormRequest
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
            'topic' => 'required|string',
            'node' => 'required|integer|between:1,4',
        ];
    }
    public function messages()
    {
        return [
            'topic.required' => 'Chủ đề là bắt buộc.',
            'topic.string' => 'Chủ đề phải là chuỗi ký tự.',
            'node.required' => 'Node là bắt buộc.',
            'node.integer' => 'Node phải là số nguyên.',
            'node.between' => 'Node phải nằm trong khoảng từ 1 đến 4.',
        ];
    }
}
