<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\Passauth\Services\PasswordForgot;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class PasswordForgotRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Passauth\Services\PasswordForgot
     */
    protected $passwordForgot;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Passauth\Services\passwordForgot $passwordForgot
     */
    public function __construct(PasswordForgot $passwordForgot)
    {
        parent::__construct();
        $this->passwordForgot = $passwordForgot;
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