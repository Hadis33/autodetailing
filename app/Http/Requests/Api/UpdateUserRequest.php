<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id ?? $this->route('user');

        return [
            'firstname' => ['sometimes', 'required', 'string', 'max:255'],
            'lastname'  => ['sometimes', 'required', 'string', 'max:255'],
            'email'     => ['sometimes', 'required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone'     => ['sometimes', 'required', 'string', 'max:50'],
            'password'  => ['sometimes', 'nullable', 'string', 'min:8'],
            'role'      => ['sometimes', 'required', 'in:admin,employee,foreman,client'],
        ];
    }
}
