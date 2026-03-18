<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-button-element
 */
final class Button extends NormalTag
{
    use TagContentTrait;

    public static function button(string|Stringable|int|float|null $content = ''): self
    {
        $button = (new self())->content($content);
        $button->attributes['type'] = 'button';
        return $button;
    }

    public static function submit(string|Stringable|int|float|null $content = ''): self
    {
        $button = (new self())->content($content);
        $button->attributes['type'] = 'submit';
        return $button;
    }

    public static function reset(string|Stringable|int|float|null $content = ''): self
    {
        $button = (new self())->content($content);
        $button->attributes['type'] = 'reset';
        return $button;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-button-type
     */
    public function type(?string $type): self
    {
        $new = clone $this;
        $new->attributes['type'] = $type;
        return $new;
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-disabledformelements-disabled
     */
    public function disabled(bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    protected function getName(): string
    {
        return 'button';
    }
}
