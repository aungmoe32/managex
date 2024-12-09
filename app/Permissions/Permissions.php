<?php

namespace App\Permissions;

use App\Models\User;

final class Permissions
{
    public const UpdateOwnProfile = 'profile:own:update';
    public const CRUDOwnPost = 'post:own:crud';
    public const CRUDAnyPost = 'post:any:crud';

    public static function adminPermissions()
    {
        return array_merge(self::userPermissions(), [
            self::CRUDAnyPost,
        ]);
    }
    public static function userPermissions()
    {
        return [
            self::CRUDOwnPost,
            self::UpdateOwnProfile,
        ];
    }
}
