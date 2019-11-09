<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use DDDTW\DDD\Common\ValueObject;

class Subcategory extends ValueObject
{
    private $name;
    private $count;
    private $amount;

    public function __construct(string $name, int $count, int $amount)
    {
        $this->name = $name;
        $this->count = $count;
        $this->amount = $amount;
    }

    public function getEqualityComponents(): array
    {
        return [
            $this->name,
            $this->count,
            $this->amount
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }
}