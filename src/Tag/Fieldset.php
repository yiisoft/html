<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\NormalTag;
use Yiisoft\Html\Tag\Base\TagContentTrait;

final class Fieldset extends NormalTag
{
    use TagContentTrait;

    private ?Legend $legend = null;

    /**
     * @param string|Stringable|null $content
     */
    public function legend($content, array $attributes = []): self
    {
        $new = clone $this;
        $new->legend = $content === null ? null : Html::legend($content, $attributes);
        return $new;
    }

    public function legendTag(?Legend $legend): self
    {
        $new = clone $this;
        $new->legend = $legend;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-elements.html#attr-fieldset-disabled
     *
     * @param bool|null $disabled Whether fieldset is disabled.
     */
    public function disabled(?bool $disabled = true): self
    {
        $new = clone $this;
        $new->attributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(?string $formId): self
    {
        $new = clone $this;
        $new->attributes['form'] = $formId;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fe-name
     */
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    protected function prepend(): string
    {
        if ($this->legend === null) {
            return '';
        }

        return "\n" . $this->legend->render() . "\n";
    }

    protected function getName(): string
    {
        return 'fieldset';
    }
}
