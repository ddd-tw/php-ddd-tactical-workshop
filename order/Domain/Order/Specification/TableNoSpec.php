<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use DDDTW\DDD\Common\Specification;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Model\OrderMethod;

class TableNoSpec extends Specification
{
    public function __construct(Order $order)
    {
        $this->entity = $order;
    }

    public function predicate(): callable
    {
        return static function(Order $order): bool {
            return !($order->getOrderMethod()->getValue() === OrderMethod::STAY_IN()->getValue() && empty($order->getTableNo()));
        };
    }
}