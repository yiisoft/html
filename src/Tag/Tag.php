<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Html;

/**
 * @psalm-type HtmlAttributes = array<string, mixed>&array{
 *   id?: string|null,
 *   class?: string[]|string|null,
 * }
 */
abstract class Tag
{
    /**
     * @psalm-var HtmlAttributes|array<empty, empty>
     */
    protected array $attributes = [];

    final private function __construct()
    {
    }

    /**
     * @return static
     */
    final public static function tag(): self
    {
        return new static();
    }

    /**
     * @psalm-param HtmlAttributes|array<empty, empty> $attributes
     */
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

    final public function addClass(string ...$class): self
    {
        $new = clone $this;
        /** @psalm-suppress MixedArgumentTypeCoercion */
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    abstract protected function getName(): string;

    abstract public function __toString(): string;
}
