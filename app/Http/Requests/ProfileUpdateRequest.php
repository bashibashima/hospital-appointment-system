<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone' => [
                'nullable',
                'regex:/^\+?[1-9]\d{9,14}$/', // E.164 format (+ followed by 10-15 digits)
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->phone) {
            $phone = preg_replace('/\D/', '', $this->phone); // keep only digits

            // If 10-digit number (Indian mobile), prepend +91
            if (preg_match('/^[6-9]\d{9}$/', $phone)) {
                $this->merge([
                    'phone' => '+91' . $phone,
                ]);
            }
            // If already starts with + (international), keep as is
            elseif (preg_match('/^\+/', $this->phone)) {
                $this->merge([
                    'phone' => $this->phone,
                ]);
            }
        }
    }
}
