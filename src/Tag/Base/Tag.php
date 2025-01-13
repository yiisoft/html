<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use BackedEnum;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

/**
 * HTML tag. Base class for all tags.
 */
abstract class Tag implements NoEncodeStringableInterface
{
    protected array $attributes = [];

    /**
     * Add a set of attributes to existing tag attributes.
     * Same named attributes are replaced.
     *
     * @param array $attributes Name-value set of attributes.
     */
    final public function addAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->attributes = array_merge($new->attributes, $attributes);
        return $new;
    }

    /**
     * Replace attributes with a new set.
     *
     * @param array $attributes Name-value set of attributes.
     */
    final public function attributes(array $attributes): static
    {
        $new = clone $this;
        $new->attributes = $attributes;
        return $new;
    }

    /**
     * Union attributes with a new set.
     *
     * @param array $attributes Name-value set of attributes.
     */
    final public function unionAttributes(array $attributes): static
    {
        $new = clone $this;
        $new->attributes += $attributes;
        return $new;
    }

    /**
     * Set attribute value.
     *
     * @param string $name Name of the attribute.
     * @param mixed $value Value of the attribute.
     */
    final public function attribute(string $name, mixed $value): static
    {
        $new = clone $this;
        $new->attributes[$name] = $value;
        return $new;
    }

    /**
     * Set tag ID.
     *
     * @param string|null $id Tag ID.
     *
     * @psalm-param non-empty-string|null $id
     */
    final public function id(?string $id): static
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Add one or more CSS classes to the tag.
     *
     * @param BackedEnum|string|null ...$class One or many CSS classes.
     */
    final public function addClass(BackedEnum|string|null ...$class): static
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Replace current tag CSS classes with a new set of classes.
     *
     * @param BackedEnum|string|null ...$class One or many CSS classes.
     */
    final public function class(BackedEnum|string|null ...$class): static
    {
        $new = clone $this;
        unset($new->attributes['class']);
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Render the current tag attributes.
     *
     * @see Html::renderTagAttributes()
     */
    final protected function renderAttributes(): string
    {
        $this->prepareAttributes();
        return Html::renderTagAttributes($this->attributes);
    }

    protected function prepareAttributes(): void
    {
    }

    final public function render(): string
    {
        return $this->before() . $this->renderTag() . $this->after();
    }

    protected function before(): string
    {
        return '';
    }

    protected function after(): string
    {
        return '';
    }

    /**
     * Render tag object into its string representation.
     *
     * @return string String representation of a tag object.
     */
    abstract protected function renderTag(): string;

    /**
     * Get tag name.
     *
     * @return string Tag name.
     */
    abstract protected function getName(): string;

    final public function __toString(): string
    {
        return $this->render();
    }
}
