<?php

namespace App\Constants;


final class Role
{
    public const STUDENT = 'student';
    public const TEACHER = 'teacher';

    public static function getAllRoles()
    {
        return [
            self::STUDENT,
            self::TEACHER,
        ];
    }
}
