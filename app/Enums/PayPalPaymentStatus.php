<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static SUCCESS()
 * @method static static CANCEL()
 * @method static static CREATED()
 * @method static static APPROVED()
 * @method static static CANCELED()
 * @method static static COMPLETED()
 * @method static static GIFT()
 */
final class PayPalPaymentStatus extends Enum
{
    const SUCCESS = 'SUCCESS';
    const CANCEL = 'CANCEL';
    const CREATED = 'CREATED';
    const CANCELED = 'CANCELED';
    const COMPLETED = 'COMPLETED';
    const GIFT = 'GIFT';
    const ACTIVE = 'ACTIVE';
    const EXPIRED = 'EXPIRED';
    const SUSPENDED = 'SUSPENDED';
    const FAILED = 'FAILED';

    public static function join($glue = '|')
    {
        return collect(self::toArray())->join($glue);
    }

}
