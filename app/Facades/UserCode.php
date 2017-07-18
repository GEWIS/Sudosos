<?php

namespace App\Facades;

use App\Models\User;

class UserCode
{
    const GEWIS_RANGE = [0,19999];
    const EXTERNAL_RANGE = [20000,39999];
    const BARCODE_RANGE = [100000, 999999];

    public static function getNextExternalUserCode() {
        $lastUser = User::where('user_code', '>=', self::EXTERNAL_RANGE[0])
            ->where('user_code', '<=', self::EXTERNAL_RANGE[1])
            ->orderBy('user_code', 'DESC')
            ->first();
        if ($lastUser === null) {
            return self::EXTERNAL_RANGE[0];
        }

        return $lastUser->user_code + 1;
    }

    public static function getNextBarCode() {
        $lastUser = User::where('user_code', '>=', self::BARCODE_RANGE[0])
            ->where('user_code', '<=', self::BARCODE_RANGE[1])
            ->orderBy('user_code', 'DESC')
            ->first();

        if ($lastUser === null) {
            return self::BARCODE_RANGE[0];
        }

        return $lastUser->user_code + 1;
    }
}