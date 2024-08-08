<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

use function implode;
use function is_array;

/**
 * @link https://www.w3.org/TR/html52/sec-forms.html#the-textarea-element
 */
final class Textarea extends NormalTag
{
    use TagContentTrait;

    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    public function rows(?int $count): self
    {
        $new = clone $this;
        $new->attributes['rows'] = $count;
        return $new;
    }

    public function columns(?int $count): self
    {
        $new = clone $this;
        $new->attributes['cols'] = $count;
        return $new;
    }

    /**
     * @param string|string[]|Stringable|null $value
     */
    public function value(string|Stringable|array|null $value): self
    {
        $content = is_array($value)
            ? implode("\n", $value)
            : (string) $value;
        return $this->content($content);
    }

    /**
     * @link https://www.w3.org/TR/html52/sec-forms.html#element-attrdef-formelements-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->attributes['form'] = $formId;
        return $new;
    }

    protected function getName(): string
    {
        return 'textarea';
    }
}
