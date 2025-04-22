<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddWordToDictionaryRequest extends FormRequest
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
            'word.required' => 'The word field is required.',
            'word.string' => 'The word field must be a string.',
            'word.max' => 'The word field may not be greater than 255 characters.',
            'ipa.string' => 'The IPA field must be a string.',
            'ipa.max' => 'The IPA field may not be greater than 255 characters.',
            'ipa.required' => 'The IPA field is required.',
            'word_type.required' => 'The word type field is required.',
            'word_type.string' => 'The word type field must be a string.',
            'word_type.max' => 'The word type field may not be greater than 50 characters.',
            'vietnamese.string' => 'The Vietnamese translation must be a string.',
            'vietnamese.max' => 'The Vietnamese translation may not be greater than 255 characters.',
            'vietnamese.required' => 'The Vietnamese translation is required.',
            'topic.required' => 'The topic field is required.',
            'topic.string' => 'The topic field must be a string.',
            'topic.max' => 'The topic field may not be greater than 100 characters.',
            'examples.string' => 'The examples field must be a string.',
            'examples.max' => 'The examples field may not be greater than 255 characters.',
            'examples_vietnamese.string' => 'The examples Vietnamese field must be a string.',
            'examples_vietnamese.max' => 'The examples Vietnamese field may not be greater than 255 characters.',
        ];
    }
}
