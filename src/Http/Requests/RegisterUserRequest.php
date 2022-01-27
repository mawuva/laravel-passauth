<?php

namespace Mawuekom\Passauth\Http\Requests;

use Illuminate\Validation\Rule;
use Mawuekom\CustomUser\DataTransferObjects\StoreUserDTO;
use Mawuekom\Passauth\Services\RegisterUser;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;

class RegisterUserRequest extends FormRequestCustomizer
{
    /**
     * @var \Mawuekom\Passauth\Services\RegisterUser
     */
    protected $registerUser;

    /**
     * Create new form request instance.
     *
     * @param \Mawuekom\Passauth\Services\RegisterUser $registerUser
     */
    public function __construct(RegisterUser $registerUser)
    {
        parent::__construct();
        $this ->registerUser = $registerUser;
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
        $usersTable = config('custom-user.user.table.name');

        $rules = [
            'name'                          => 'string|nullable',

            'email'                         => [
                'required', 'string', 'email', Rule::unique($usersTable, 'email')
            ],
            
            'password'                      => 'string|min:6|confirmed',
            'first_name'                    => 'string|nullable',
            'phone_number'                  => 'string|nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
            'agree_with_policy_and_terms'   => 'string|nullable',
        ];

        (!get_attribute('name', 'optional'))
            ?? array_push($rules['name'], 'required');

        (get_attribute('phone_number', 'unique'))
            ?? array_push($rules['phone_number'], Rule::unique($usersTable, 'phone_number'));

        return $rules;
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [
            'name' => [
                CapitalizeEachWords::class,
            ],
            'first_name' => [
                CapitalizeEachWords::class,
            ],
        ];
    }

    /**
     * Build and return a DTO
     *
     * @return \Mawuekom\CustomUser\DataTransferObjects\StoreUserDTO
     */
    public function toDTO(): StoreUserDTO
    {
        return new StoreUserDTO([
            'name'                          => $this ->name,
            'email'                         => $this ->email,
            'password'                      => $this ->password,
            'first_name'                    => $this ->first_name,
            'phone_number'                  => $this ->phone_number,
            'agree_with_policy_and_terms'   => $this ->agree_with_policy_and_terms,
        ]);
    }

    /**
     * Fulfill the update account type request
     *
     * @param string|null $callback_url
     * @param string|null $view
     * 
     * @return array
     */
    public function fulfill($callback_url = null, $view = null): array
    {
        return call_user_func($this ->registerUser, $this ->toDTO(), $callback_url, $view);
    }
}
