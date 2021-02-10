<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use JsonException;
use Yiisoft\Html\Html;
use Yiisoft\Json\Json;

use function in_array;
use function is_array;
use function is_bool;

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
     * The preferred order of attributes in a tag. This mainly affects the order of the attributes that are
     * rendered by {@see renderAttributes()}.
     */
    private const ATTRIBUTE_ORDER = [
        'type',
        'id',
        'class',
        'name',
        'value',

        'href',
        'src',
        'srcset',
        'form',
        'action',
        'method',

        'selected',
        'checked',
        'readonly',
        'disabled',
        'multiple',

        'size',
        'maxlength',
        'width',
        'height',
        'rows',
        'cols',

        'alt',
        'title',
        'rel',
        'media',
    ];

    /**
     * List of tag attributes that should be specially handled when their values are of array type.
     * In particular, if the value of the `data` attribute is `['name' => 'xyz', 'age' => 13]`, two attributes will be
     * generated instead of one: `data-name="xyz" data-age="13"`.
     */
    private const DATA_ATTRIBUTES = ['data', 'data-ng', 'ng', 'aria'];

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
        $new->attributes = array_merge($new->attributes, $attributes);
        return $new;
    }

    /**
     * @psalm-param HtmlAttributes|array<empty, empty> $attributes
     */
    final public function replaceAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->attributes = $attributes;
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
     * Renders the HTML tag attributes.
     *
     * Attributes whose values are of boolean type will be treated as
     * [boolean attributes](http://www.w3.org/TR/html5/infrastructure.html#boolean-attributes).
     *
     * Attributes whose values are null will not be rendered. The values of attributes will be HTML-encoded using
     * {@see Html::encodeAttribute()}.
     *
     * The "data" attribute is specially handled when it is receiving an array value. In this case, the array will be
     * "expanded" and a list data attributes will be rendered. For example, if `'data' => ['id' => 1, 'name' => 'yii']`
     * then this will be rendered `data-id="1" data-name="yii"`.
     *
     * Additionally `'data' => ['params' => ['id' => 1, 'name' => 'yii'], 'status' => 'ok']` will be rendered as:
     * `data-params='{"id":1,"name":"yii"}' data-status="ok"`.
     *
     * The attribute values will be HTML-encoded using {@see Html::encodeAttribute()}.
     *
     * @throws JsonException
     *
     * @return string The rendering result. If the attributes are not empty, they will be rendered into a string
     * with a leading white space (so that it can be directly appended to the tag name in a tag). If there is no
     * attribute, an empty string will be returned.
     */
    final protected function renderAttributes(): string
    {
        $attributes = $this->attributes;

        if (count($attributes) > 1) {
            $sorted = [];
            foreach (self::ATTRIBUTE_ORDER as $name) {
                if (isset($attributes[$name])) {
                    /** @var mixed */
                    $sorted[$name] = $attributes[$name];
                }
            }
            $attributes = array_merge($sorted, $attributes);
        }

        $html = '';
        /** @var mixed $value */
        foreach ($attributes as $name => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $html .= " $name";
                }
            } elseif (is_array($value)) {
                if (in_array($name, self::DATA_ATTRIBUTES, true)) {
                    /** @psalm-var array<array-key, array|string|\Stringable|null> $value */
                    foreach ($value as $n => $v) {
                        if (is_array($v)) {
                            $html .= " $name-$n='" . Json::htmlEncode($v) . "'";
                        } else {
                            $html .= " $name-$n=\"" . Html::encodeAttribute($v) . '"';
                        }
                    }
                } elseif ($name === 'class') {
                    if (empty($value)) {
                        continue;
                    }
                    $html .= " $name=\"" . Html::encodeAttribute(implode(' ', $value)) . '"';
                } elseif ($name === 'style') {
                    if (empty($value)) {
                        continue;
                    }
                    /** @psalm-var array<string, string> $value */
                    $html .= " $name=\"" . Html::encodeAttribute(Html::cssStyleFromArray($value)) . '"';
                } else {
                    $html .= " $name='" . Json::htmlEncode($value) . "'";
                }
            } elseif ($value !== null) {
                $html .= " $name=\"" . Html::encodeAttribute($value) . '"';
            }
        }

        return $html;
    }

    abstract public function render(): string;

    abstract protected function getName(): string;

    final public function __toString(): string
    {
        return $this->render();
    }
}
