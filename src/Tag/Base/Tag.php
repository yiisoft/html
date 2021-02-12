<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;

/**
 * @psalm-type HtmlAttributes = array<string, mixed>&array{
 *   id?: string|\Stringable|null,
 *   class?: string[]|string|\Stringable[]|\Stringable|null,
 *   data?: array<array-key, array|string|\Stringable|null>|string|\Stringable|null,
 *   data-ng?: array<array-key, array|string|\Stringable|null>|string|\Stringable|null,
 *   ng?: array<array-key, array|string|\Stringable|null>|string|\Stringable|null,
 *   aria?: array<array-key, array|string|\Stringable|null>|string|\Stringable|null,
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
     *
     * @return static
     */
    final public function attributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $attributes);
        return $new;
    }

    /**
     * @psalm-param HtmlAttributes|array<empty, empty> $attributes
     *
     * @return static
     */
    final public function replaceAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    final public function attribute(string $key, $value): self
    {
        $new = clone $this;
        $new->attributes[$key] = $value;
        return $new;
    }

    /**
     * @return static
     */
    final public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * @return static
     */
    final public function class(string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = $class;
        return $new;
    }

    /**
     * @return static
     */
    final public function addClass(string ...$class): self
    {
        $new = clone $this;
        /** @psalm-suppress MixedArgumentTypeCoercion */
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Renders the current tag attributes.
     *
     * @see Html::renderTagAttributes()
     */
    final protected function renderAttributes(): string
    {
        return Html::renderTagAttributes($this->attributes);
    }

    abstract public function render(): string;

    abstract protected function getName(): string;

    final public function __toString(): string
    {
        return $this->render();
    }
}
