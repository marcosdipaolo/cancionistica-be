<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'email' => "required|email:rfc,dns",
            'message' => 'required|min:10|max:1500'
        ];
    }

    public function getName(): string {
        return filter_var($this->get("name"), FILTER_SANITIZE_STRING);
    }

    public function getMessage(): string {
        return filter_var($this->get("message"), FILTER_SANITIZE_STRING);
    }

    public function getEmail(): string {
        return filter_var($this->get("email"), FILTER_SANITIZE_EMAIL);
    }
}
