<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class StatusCartEnum extends Enum
{
    const DA_HUY = 0;
    const CHUA_DUYET = 1;
    const DANG_GIAO = 2;
    const DA_GIAO = 3;
}
