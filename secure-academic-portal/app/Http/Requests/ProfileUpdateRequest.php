<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $identifierField = $this->user()->academicIdentifierField();

        return [
            'name' => ['required', 'string', 'max:255'],
            'nrp' => $identifierField === 'nrp'
                ? ['nullable', 'string', 'regex:/^[0-9]{10,20}$/', Rule::unique(User::class, 'nrp')->ignore($this->user()->id)]
                : ['prohibited'],
            'nip' => $identifierField === 'nip'
                ? ['nullable', 'string', 'regex:/^[0-9]{10,20}$/', Rule::unique(User::class, 'nip')->ignore($this->user()->id)]
                : ['prohibited'],
            'department' => ['sometimes', 'required', 'string', 'max:150'],
            'bio' => ['nullable', 'string', 'max:2000'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    /** @return array<string, string> */
    public function attributes(): array
    {
        return ['nrp' => 'NRP', 'nip' => 'NIP'];
    }
}
