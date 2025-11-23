<?php

namespace App\Modules\Authentication\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthSignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:320|unique:users',
            'password' => 'required|string|min:8',
            'gender_code' => 'required|in:M,F,N',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'email.email' => 'Email field must be a valid email address.',
            'email.unique' => 'This email is already taken.',
            'password.required' => 'Password field is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'gender_code.required' => 'Gender is required.',
            'gender_code.in' => 'Invalid gender selected.',
            'avatar.image' => 'Avatar must be an image.',
            'avatar.mimes' => 'Avatar must be a JPG or PNG file.',
            'avatar.max' => 'Avatar size must not exceed 3MB.',
        ];
    }
}
