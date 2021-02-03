<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Html;

abstract class Tag
{
    protected array $attributes = [];
    
    final protected function __construct()
    {
    }

    final public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    final public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    final public function class(string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = $class;
        return $new;
    }

    final public function addedClass(string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    abstract protected function getName(): string;

    abstract public function __toString(): string;
}
