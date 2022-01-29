<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\Passauth\DataTransferObjects\LoginUserDTO;
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
     * @param \Mawuekom\Passauth\Services\LoginUser $loginUser
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
     * Build and return a DTO
     *
     * @return \Mawuekom\Passauth\DataTransferObjects\LoginUserDTO
     */
    public function toDTO(): LoginUserDTO
    {
        return new LoginUserDTO([
            'identifiant'   => $this ->identifiant,
            'password'      => $this ->password
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return call_user_func($this ->loginUser, $this ->toDTO());
    }
}