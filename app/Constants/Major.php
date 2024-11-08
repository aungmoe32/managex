<?php

namespace App\Constants;


final class Major
{
    public const IT = 'IT';
    public const CIVIL = 'CIVIL';
    public const EP = 'EP';

    public static function getAllMajors()
    {
        return [
            self::IT,
            self::CIVIL,
            self::EP,
        ];
    }
}
