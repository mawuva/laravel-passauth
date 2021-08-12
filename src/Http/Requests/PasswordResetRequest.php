<?php

namespace Domain\Passauth\Http\Requests;

use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class PasswordResetRequest extends FormRequestCustomizer
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
            'token'     => 'required',
            'email'     => 'required|email',
            'password'  => 'required|min:6|confirmed',
        ];
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [];
    }
}