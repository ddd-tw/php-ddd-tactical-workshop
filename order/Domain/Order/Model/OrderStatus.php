<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use DDDTW\DDD\Common\Enum;

/**
 * @method static OrderStatus CREATED()
 */
class OrderStatus extends Enum
{
    private const CREATED = 0;
}