<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Yiisoft\Html\Html;

/**
 * @psalm-import-type HtmlAttributes from Html
 */
abstract class Tag
{
    /**
     * @psalm-var HtmlAttributes|array<empty, empty>
     */
    protected array $attributes = [];

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
