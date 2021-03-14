<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

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
     * Replace attributes with a new set.
     *
     * @param array $attributes Name-value set of attributes.
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
     * Set attribute value.
     *
     * @param string $name Name of the attribute.
     * @param mixed $value Value of the attribute.
     *
     * @return static
     */
    final public function attribute(string $name, $value): self
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
     * @return static
     */
    final public function id(?string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    /**
     * Add one or more CSS classes to the tag.
     *
     * @param string ...$class One or many CSS classes.
     *
     * @return static
     */
    final public function class(string ...$class): self
    {
        $new = clone $this;
        /** @psalm-suppress MixedArgumentTypeCoercion */
        Html::addCssClass($new->attributes, $class);
        return $new;
    }

    /**
     * Replace current tag CSS classes with a new set of classes.
     *
     * @param string ...$class One or many CSS classes.
     *
     * @return static
     */
    final public function replaceClass(string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = $class;
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
