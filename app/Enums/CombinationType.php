<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADMIN()
 * @method static static USER()
 * @method static static FORMATTED()
 */
final class CombinationType extends Enum
{
    const PRO = 'pro';
    const MINE = 'mine';
}
