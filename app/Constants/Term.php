<?php

namespace App\Constants;


final class Term
{
    public const First = 'First';
    public const Second = 'Second';

    public static function getAllTerms()
    {
        return [
            self::First,
            self::Second
        ];
    }
}
