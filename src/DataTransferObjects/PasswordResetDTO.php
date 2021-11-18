<?php

namespace Mawuekom\Passauth\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class PasswordResetDTO extends DataTransferObject
{
    public string $token;
    public string $email;
    public string $password;
}