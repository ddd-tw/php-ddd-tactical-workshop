<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use DDDTW\DDD\Common\Enum;

/**
 * @method static OrderMethod TOGO()
 * @method static OrderMethod STAY_IN()
 */
class OrderMethod extends Enum
{
    private const TOGO = 0;
    private const STAY_IN = 1;
}