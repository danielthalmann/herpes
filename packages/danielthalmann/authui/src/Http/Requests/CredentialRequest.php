<?php

namespace Danielthalmann\AuthUi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CredentialRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|min:1|max:255',
            'password' => 'required|min:1|max:255'
        ];
    }
}
