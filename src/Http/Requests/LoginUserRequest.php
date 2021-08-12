<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class LoginUserRequest extends FormRequestCustomizer
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
            'identifiant'    => 'required|string|max:255',
            'password'      => 'required|string|min:6',
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