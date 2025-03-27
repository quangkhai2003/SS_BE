<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FApiRequest extends FormRequest
{
    Public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        return [
            'file' => 'required|file|max:10240',
        ];
    }
    public function messages()
    {
        return [
           'file.required' => 'Please upload a file',
           'file.file' => 'Please upload a file',
           'file.max' => 'File size should not exceed',
        ];
    }
}