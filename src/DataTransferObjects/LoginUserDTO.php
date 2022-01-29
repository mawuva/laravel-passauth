<?php

namespace Mawuekom\Passauth\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class LoginUserDTO extends DataTransferObject
{
    public string $identifiant;
    public string $password;
}