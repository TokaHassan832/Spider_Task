<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username' => 'required|regex:/^\S*$/u',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*?&#]/',
            'image' => 'nullable|image|mimes:png,jpg|max:1024'
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => __('validation.username_required'),
            'username.regex' => __('validation.username_no_spaces'),
            'email.required' => __('validation.email_required'),
            'email.email' => __('validation.email_format'),
            'email.unique' => __('validation.email_unique'),
            'password.required' => __('validation.password_required'),
            'password.min' => __('validation.password_min'),
            'password.regex' => __('validation.password_format'),
            'image.image' => __('validation.image_format'),
            'image.mimes' => __('validation.image_mimes'),
            'image.max' => __('validation.image_max'),
        ];
    }
}
