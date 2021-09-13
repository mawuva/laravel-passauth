<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\Passauth\Services\LoginUser;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;

class LoginUserRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Passauth\Services\LoginUser
     */
    protected $loginUser;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Passauth\Services\LoginUser $registerUser
     */
    public function __construct(LoginUser $loginUser)
    {
        parent::__construct();
        $this->loginUser = $loginUser;
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
            'identifiant'   => 'required|string|max:255',
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

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return call_user_func($this ->loginUser, $this ->validated());
    }
}