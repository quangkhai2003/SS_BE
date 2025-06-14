<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,user_id',
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($this->user_id, 'user_id'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user_id, 'user_id'),
            ],
            'password' => 'required|string|min:8',
            'role' => 'in:User,Guest', // Chỉ cho phép các giá trị hợp lệ
        ];
    }
    public function messages()
    {
        return [
            'user_id.required' => 'ID người dùng là bắt buộc.',
            'user_id.integer' => 'ID người dùng phải là một số nguyên.',
            'user_id.exists' => 'ID người dùng không tồn tại.',
            'username.required' => 'Tên người dùng là bắt buộc.',
            'username.unique' => 'Tên người dùng đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'role.in' => 'Vai trò phải là một trong các giá trị: User hoặc Guest.', // Thông báo lỗi cho role
        ];
    }
}
