<?php

namespace Mawuekom\Passauth\Services;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Mawuekom\CustomUser\Facades\CustomUser;

class VerifyEmail
{
    /**
     * Handle verify email.
     *
     * @param int|string $id
     * @param string $hash
     *
     * @return array
     */
    public function __invoke($id, $hash): array
    {
        $user = CustomUser::getUserById($id);

        if (is_null($user)) {
            throw new Exception(trans('passauth::messages.user_not_found'), Response::HTTP_NOT_FOUND);
        }

        if (! hash_equals((string) $hash, sha1($user ->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if (! $user ->hasVerifiedEmail()) {
            $user ->markEmailAsVerified();
        }

        return success_response(trans('userly::messages.email_verified'));
    }
}