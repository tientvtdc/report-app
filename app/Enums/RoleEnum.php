<?php

namespace App\Enums;
enum RoleEnum: string
{
    // case NAMEINAPP = 'name-in-database';

    case WRITER = 'WRITER';
    case EDITOR = 'EDITOR';
    case USER_MANAGER = 'USER_MANAGER';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::WRITER => 'Writers',
            static::EDITOR => 'Editors',
            static::USER_MANAGER => 'User Managers',
        };
    }
}
