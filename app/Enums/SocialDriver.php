<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static FACEBOOK()
 * @method static static GOOGLE()
 * @method static static APPLICATION()
 */
final class SocialDriver extends Enum
{
    const FACEBOOK = 'facebook';
    const GOOGLE = 'google';
    const APPLICATION = 'application';
}
