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
}