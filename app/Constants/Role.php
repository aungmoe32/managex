<?php

namespace App\Constants;


final class Role
{
    public const USER = 'USER';
    public const ADMIN = 'ADMIN';

    public static function getAllRoles()
    {
        return [
            self::USER,
            self::ADMIN,
        ];
    }
}
