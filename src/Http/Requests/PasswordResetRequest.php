<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\Passauth\Services\PasswordReset;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class PasswordResetRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Passauth\Services\PasswordReset
     */
    protected $passwordReset;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Passauth\Services\PasswordReset $passwordReset
     */
    public function __construct(PasswordReset $passwordReset)
    {
        parent::__construct();
        $this->passwordReset = $passwordReset;
    }
    
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

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return [];
    }
}