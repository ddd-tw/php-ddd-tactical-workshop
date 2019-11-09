<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use DateTime;
use DDDTW\DDD\Common\Entity;
use Order\Domain\Order\Exception\CategoryIsEmptyException;
use Order\Domain\Order\Exception\TableNumberEmptyWhenStayInException;
use Order\Domain\Order\Specification\CategorySpec;
use Order\Domain\Order\Specification\TableNoSpec;

class Order extends Entity
{
    /**
     * @var OrderId
     */
    private $orderId;
    /**
     * @var OrderMethod
     */
    private $orderMethod;
    /**
     * @var OrderStatus
     */
    private $status;

    /**
     * @var string
     */
    private $tableNo;
    /**
     * @var Category[]
     */
    private $categories;

    public function __construct(OrderId $orderId, OrderMethod $orderMethod, OrderStatus $status, string $tableNo, array $categories)
    {
        $this->orderId = $orderId;
        $this->orderMethod = $orderMethod;
        $this->status = $status;
        $this->tableNo = $tableNo;
        $this->categories = $categories;

        parent::__construct();
    }

    /**
     * @param OrderId $orderId
     * @param OrderMethod $orderMethod
     * @param string $tableNo
     * @param array $categories
     * @return Order
     * @throws CategoryIsEmptyException
     * @throws TableNumberEmptyWhenStayInException
     */
    public static function createOrder(OrderId $orderId, OrderMethod $orderMethod, string $tableNo, array $categories): Order
    {
        $order = new Order($orderId, $orderMethod, OrderStatus::CREATED(), $tableNo, $categories);

        $categorySpec = new CategorySpec($order);
        if (!$categorySpec->isSatisfy()) {
            throw new CategoryIsEmptyException('category must be set in order');
        }

        $tableNoSpec = new TableNoSpec($order);
        if (!$tableNoSpec->isSatisfy()) {
            throw new TableNumberEmptyWhenStayInException('tableNo must set when stay in');
        }

        return $order;
    }

    /**
     * @return OrderId
     */
    public function getOrderId(): OrderId
    {
        return $this->orderId;
    }

    /**
     * @return OrderMethod
     */
    public function getOrderMethod(): OrderMethod
    {
        return $this->orderMethod;
    }

    /**
     * @return OrderStatus
     */
    public function getStatus(): OrderStatus
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getTableNo(): string
    {
        return $this->tableNo;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getIdentity(): string
    {
        return $this->getOrderId()->toString();
    }
}