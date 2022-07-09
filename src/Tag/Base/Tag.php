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
     *
     * @deprecated Use {@see addAttributes()} or {@see replaceAttributes()} instead. In the next major version
     * `replaceAttributes()` method will be renamed to `attributes()`.
     */
    final public function attributes(array $attributes): self
    {
        return $this->addAttributes($attributes);
    }

    /**
     * Add a set of attributes to existing tag attributes.
     * Same named attributes are replaced.
     *
     * @param array $attributes Name-value set of attributes.
     *
     * @return static
     */
    final public function addAttributes(array $attributes): self
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
     * Union attributes with a new set.
     *
     * @param array $attributes Name-value set of attributes.
     *
     * @return static
     */
    final public function unionAttributes(array $attributes): self
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
     * @param string|null ...$class One or many CSS classes.
     *
     * @return static
     *
     * @deprecated Use {@see addClass()} or {@see replaceClass()} instead. In the next major version `replaceClass()`
     * method will be renamed to `class()`.
     */
    final public function class(?string ...$class): self
    {
        return $this->addClass(...$class);
    }

    /**
     * Add one or more CSS classes to the tag.
     *
     * @param string|null ...$class One or many CSS classes.
     *
     * @return static
     */
    final public function addClass(?string ...$class): self
    {
        $new = clone $this;
        Html::addCssClass(
            $new->attributes,
            array_filter($class, static fn ($c) => $c !== null),
        );
        return $new;
    }

    /**
     * Replace current tag CSS classes with a new set of classes.
     *
     * @param string|null ...$class One or many CSS classes.
     *
     * @return static
     */
    final public function replaceClass(?string ...$class): self
    {
        $new = clone $this;
        $new->attributes['class'] = array_filter($class, static fn ($c) => $c !== null);
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
