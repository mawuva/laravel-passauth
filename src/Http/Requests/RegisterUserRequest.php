<?php

namespace Mawuekom\Passauth\Http\Requests;

use Mawuekom\Passauth\Services\RegisterUser;
use Mawuekom\RequestCustomizer\FormRequestCustomizer;
use Mawuekom\RequestSanitizer\Sanitizers\CapitalizeEachWords;
use Mawuekom\RequestSanitizer\Sanitizers\Uppercase;

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
        $users_table = config('passauth.user.table.name');

        $proper_names_rules = (proper_names_is_required_and_exists())
                                ? ['last_name' => 'string', 'first_name' => 'string']
                                : [];

        $email_rules = (email_is_defined_as_identifiant())
                        ? ['email' => 'required|string|email|unique:'.$users_table]
                        : ['email' => 'string|email|unique:'.$users_table];
        
        $phone_number_rules = (phone_number_is_required_and_exists())
                                ? ['phone_number' => 'required|string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:'.$users_table]
                                : ['phone_number' => 'string|regex:/^([0-9\s\-\+\(\)]*)$/|unique:'.$users_table];

        return array_merge([
            'name'      => 'string|unique:'.$users_table,
            'password'  => 'required|string|min:6|confirmed',
            'agree_with_policy_and_term' => ''
        ], $email_rules, $phone_number_rules, $proper_names_rules);
    }

    /**
     * Get sanitizers defined for form input
     *
     * @return array
     */
    public function sanitizers(): array
    {
        return [
            'last_name' => [
                Uppercase::class,
            ],
            'first_name' => [
                CapitalizeEachWords::class,
            ],
        ];
    }

    /**
     * Fulfill the update account type request
     *
     * @return array
     */
    public function fulfill(): array
    {
        return call_user_func($this ->registerUser, $this ->validated());
    }
}