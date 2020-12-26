<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADMIN()
 * @method static static USER()
 * @method static static FORMATTED()
 */
final class Role extends Enum
{
    const ADMIN = 'admin';
    const USER = 'user';

    const FORMATTED = [
        self::ADMIN => 'Administrador',
        self::USER => 'Usuário',
    ];

    public static function toArray(): array
    {
        return [self::ADMIN, self::USER];
    }

    public static function toCollect()
    {
        return collect(self::toArray());
    }

}
