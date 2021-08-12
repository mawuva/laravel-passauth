<?php

namespace Mawuekom\Passauth\Services;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RegisterUser
{
    /**
     * Store user data
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    private function storeUserData(array $data): Model
    {
        $user = app() ->make(config('passauth.user.model'));

        $user ->name        = $this ->resolveUsername($data);
        $user ->email       = check_input_value($data, 'email');
        
        if (proper_names_is_required_and_exists()) {
            $user ->last_name   = strtoupper(check_input_value($data, 'last_name'));
            $user ->first_name  = ucwords(check_input_value($data, 'first_name'));
        }

        if (phone_number_is_required_and_exists()) {
            $user ->phone_number    = check_input_value($data, 'phone_number');
        }

        $user ->password    = $this ->resolvePassword($data['password']);

        if (agree_with_policy_and_terms_is_enabled_and_exists() && check_input_value($data, 'agree_with_policy_and_term')) {
            $agree_with_policy_and_terms_column_name = config('passauth.agree_with_policy_and_terms_column.name');
            $user ->{$agree_with_policy_and_terms_column_name} = Carbon::now();
        }

        $user ->save();

        return $user;
    }
    
    /**
     * Resolve user's username
     *
     * @param array $data
     *
     * @return string
     */
    private function resolveUsername(array $data): string
    {
        if (check_input_value($data, 'name') !== null) {
            return $data['name'];
        }

        elseif (check_input_value($data, 'username') !== null) {
            return $data['username'];
        }

        elseif (check_input_value($data, 'email') != null) {
            return explode('@', $data['email'])[0].'-'.define_random_username(3, 6, false);
        }

        else {
            return define_random_username();
        }
    }

    /**
     * Resolve user's password.
     *
     * @param string $password
     *
     * @return string
     */
    private function resolvePassword(string $password): string
    {
        return (method_exists(config('passauth.user.model'), 'setPasswordAttribute'))
                    ? $password
                    : bcrypt($password);
    }
}