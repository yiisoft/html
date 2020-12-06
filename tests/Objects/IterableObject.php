<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use ArrayIterator;
use IteratorAggregate;

final class IterableObject implements IteratorAggregate
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->data);
    }
}
