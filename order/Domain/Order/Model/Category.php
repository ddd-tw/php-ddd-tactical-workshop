<?php

declare(strict_types=1);

namespace Order\Domain\Order\Model;

use DDDTW\DDD\Common\ValueObject;

class Category extends ValueObject
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var Subcategory[]
     */
    private $subcategories;

    public function __construct(string $name, array $subcategories)
    {
        $this->name = $name;
        $this->subcategories = $subcategories;
    }

    public function getEqualityComponents(): array
    {
        $props = [];
        $props[] = $this->name;

        foreach ($this->subcategories as $category) {
            $props[] = $category->getName();
            $props[] = $category->getCount();
            $props[] = $category->getAmount();
        }

        return $props;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getSubcategories(): array
    {
        return $this->subcategories;
    }
}