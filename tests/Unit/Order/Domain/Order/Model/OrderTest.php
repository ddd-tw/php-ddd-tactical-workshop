<?php

declare(strict_types=1);

namespace Tests\Unit\Order\Domain\Order\Model;

use DateTime;
use Order\Domain\Order\Exception\CategoryIsEmptyException;
use Order\Domain\Order\Exception\TableNumberEmptyWhenStayInException;
use Order\Domain\Order\Model\Category;
use Order\Domain\Order\Model\Order;
use Order\Domain\Order\Model\OrderId;
use Order\Domain\Order\Model\OrderMethod;
use Order\Domain\Order\Model\OrderStatus;
use Order\Domain\Order\Model\Subcategory;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    /**
     * @throws CategoryIsEmptyException
     * @throws TableNumberEmptyWhenStayInException
     */
    public function testCreateOrder(): void
    {
        $orderId = new OrderId(1, new DateTime());
        $categories = [
            new Category('cate', [new Subcategory('sub', 1, 10)])
        ];

        $order = Order::createOrder($orderId, OrderMethod::STAY_IN(), '1', $categories);

        $this->assertEquals(OrderStatus::CREATED(), $order->getStatus());
    }

    /**
     * @throws CategoryIsEmptyException
     * @throws TableNumberEmptyWhenStayInException
     */
    public function testCreateOrder_EmptyCategories_ThrowException(): void
    {
        $this->expectException(CategoryIsEmptyException::class);

        $orderId = new OrderId(1, new DateTime());

        Order::createOrder($orderId, OrderMethod::STAY_IN(), '1', []);
    }

    /**
     * @throws CategoryIsEmptyException
     * @throws TableNumberEmptyWhenStayInException
     */
    public function testCreateOrder_TableNoEmptyWhenStayIn_ThrowException(): void
    {
        $this->expectException(TableNumberEmptyWhenStayInException::class);

        $orderId = new OrderId(1, new DateTime());
        $categories = [
            new Category('cate', [new Subcategory('sub', 1, 10)])
        ];

        Order::createOrder($orderId, OrderMethod::STAY_IN(), '', $categories);
    }
}
