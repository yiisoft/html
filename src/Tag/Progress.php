<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

/**
 * @link https://html.spec.whatwg.org/multipage/form-elements.html#the-progress-element
 */
final class Progress extends NormalTag
{
    use TagContentTrait;

    public function max(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['max'] = $value;
        return $new;
    }

    public function value(float|int|null $value): self
    {
        $new = clone $this;
        $new->attributes['value'] = $value;
        return $new;
    }

    protected function getName(): string
    {
        return 'progress';
    }
}
