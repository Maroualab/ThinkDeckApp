<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UpdateAuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Ensure the user is authorized to update their own information
        return auth()->check() && auth()->id() === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user()->id),
            ],
            'current_password' => ['required_with:password', 'current_password'],
            'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Handle password hashing before validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if ($this->password) {
            $this->merge([
                'password' => Hash::make($this->password)
            ]);
        }
    }
}