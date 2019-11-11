<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use DDDTW\DDD\Common\Entity;

/**
 * 開始定義你的參數吧!!!
 * 記得參數應該都要是 private 的喔
 *
 * Class Order
 * @package Order\Domain\Order\Model
 */
class Order extends Entity
{
    public function getIdentity(): string
    {
        // TODO: Implement getIdentity() method.
        return '';
    }
}