<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\Passauth\Services\PasswordConfirmation;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class PasswordConfirmationRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Passauth\Services\PasswordConfirmation
     */
    protected $passwordConfirmation;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Passauth\Services\PasswordConfirmation $passwordConfirmation
     */
    public function __construct(PasswordConfirmation $passwordConfirmation)
    {
        parent::__construct();
        $this->passwordConfirmation = $passwordConfirmation;
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
            'password' => 'string|required|min:6'
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
        return call_user_func($this ->passwordConfirmation, [
            auth() ->user() ->id, 
            $this ->password
        ]);
    }
}