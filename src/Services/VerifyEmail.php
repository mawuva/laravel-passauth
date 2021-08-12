<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;

class VerifyEmail
{
    /**
     * Handle verify email.
     *
     * @param int|string $user_id
     * @param string $hash
     *
     * @return array
     */
    public function __invoke($user_id, $hash): array
    {
        $resource = config('passauth.user.resource_name');
        $resourceKey = resolve_key($resource, $user_id);
        
        $user = config('passauth.user.model')::where($resourceKey, $user_id) ->first();

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }

        if (! hash_equals((string) $hash, sha1($user ->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if (! $user ->hasVerifiedEmail()) {
            $user ->markEmailAsVerified();
        }

        return success_reply(trans('userly::messages.email_verified'));
    }
}