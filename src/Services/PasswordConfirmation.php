<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PasswordConfirmation
{
    /**
     * Handle password confirmation request.
     * 
     * @param int|string $user_id
     * @param string $password
     * 
     * @return array
     */
    public function __invoke(int|string $user_id, string $password): array
    {
        $resource = config('passauth.user.resource_name');
        $resourceKey = resolve_key($resource, $user_id);
        
        $user = config('passauth.user.model')::where($resourceKey, $user_id) ->first();

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }
        
        if (!Hash::check($password, $user ->password)) {
            throw new Exception(trans('passauth::messages.password_not_matching'), Response::HTTP_BAD_REQUEST);
        }

        return success_reply(trans('passauth::messages.password_matching'), $user);
    }
}