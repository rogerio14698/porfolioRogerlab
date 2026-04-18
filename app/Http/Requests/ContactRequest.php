<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContactRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'subject' => ['required', 'string', 'min:3', 'max:150'],
            'email' => ['required', 'string', 'max:255', 'email:rfc,dns'],
            'message' => ['required', 'string', 'min:20', 'max:5000'],
            'company' => ['nullable', 'string', 'max:255'],
            'cf-turnstile-response' => [
                Rule::requiredIf(! app()->environment(['local', 'testing'])),
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.email' => 'Introduce un correo real con dominio valido.',
            'cf-turnstile-response.required' => 'Completa la verificacion de seguridad antes de enviar.',
            'message.min' => 'El mensaje debe tener al menos 20 caracteres.',
        ];
    }
}