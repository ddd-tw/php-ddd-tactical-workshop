<?php

declare(strict_types=1);

namespace Order\Domain\Order\Specification;

use DDDTW\DDD\Common\Specification;
use Order\Domain\Order\Model\Order;

class CategorySpec extends Specification
{
    public function __construct(Order $order)
    {
        $this->entity = $order;
    }

    public function predicate(): callable
    {
        return static function(Order $order): bool {
            return !empty($order->getCategories());
        };
    }
}