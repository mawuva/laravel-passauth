<?php

namespace Mawuekom\Passauth\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class LoginUser
{
    /**
     * Handle user login.
     *
     * @param array $credentials
     *
     * @return array
     */
    public function __invoke(array $credentials): array
    {
        $user = $this ->checkIdentifiant($credentials['identifiant']);

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.identifiant_not_matching'), Response::HTTP_BAD_REQUEST);
        }

        if (!Hash::check($credentials['password'], $user ->password)) {
            throw new Exception(trans('passauth::messages.password_not_matching'), Response::HTTP_BAD_REQUEST);
        }

        $this ->updateLastLogintAt($user);

        return success_reply(trans('passauth::messages.user_login_successfully'), $user);
    }
    
    /**
     * Check user identifiant.
     *
     * @param string $identifiant
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private function checkIdentifiant(string $identifiant): ?Model
    {
        $user = app() ->make(config('passauth.user.model'));

        $result = $user ->where('email', $identifiant)
                        ->orWhere('name', $identifiant);
        
        if (phone_number_is_required_and_exists()) {
            $result ->orWhere('phone_number', $identifiant);
        }

        return $result ->first();
    }

    /**
     * Update user's last login time
     *
     * @param \Illuminate\Database\Eloquent\Model $user
     *
     * @return void
     */
    public function updateLastLogintAt(Model $user)
    {
        if (last_login_is_enabled_and_exists()) {
            $last_login_column_name = config('passauth.last_login_column.name');
            $user ->{$last_login_column_name} = Carbon::now();
            $user ->save();
        }
    }
}