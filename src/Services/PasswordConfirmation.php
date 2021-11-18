<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mawuekom\CustomUser\Facades\CustomUser;

class PasswordConfirmation
{
    /**
     * Handle password confirmation request.
     * 
     * @param int|string $id
     * @param string $password
     * 
     * @return array
     */
    public function __invoke($id, string $password): array
    {
        $user = CustomUser::getUserById($id);

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }
        
        if (!Hash::check($password, $user ->password)) {
            throw ValidationException::withMessages(['password' =>trans('passauth::messages.password_not_matching')]);
        }

        return success_response(trans('passauth::messages.password_matching'), $user);
    }
}