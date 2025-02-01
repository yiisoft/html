<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Stringable;
use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mo
 */
final class Mo extends NormalTag implements MathItemInterface
{
    private string|Stringable $operator;

    protected function getName(): string
    {
        return 'mo';
    }

    protected function generateContent(): string
    {
        return (string) $this->operator;
    }

    public function operator(string|Stringable $operator): self
    {
        $new = clone $this;
        $new->operator = $operator;

        return $new;
    }

    public function form(OperatorForm|null $form): self
    {
        $new = clone $this;

        if ($form) {
            $new->attributes['form'] = $form->name;
        } else {
            unset($new->attributes['form']);
        }

        return $new;
    }
}
