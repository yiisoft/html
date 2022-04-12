<?php

declare(strict_types=1);

namespace Yiisoft\Html\Widget;

use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Html\Tag\Button;

final class ButtonGroup implements NoEncodeStringableInterface
{
    private ?string $containerTag = 'div';
    private array $containerAttributes = [];

    /**
     * @var Button[]
     */
    private array $buttons = [];
    private array $buttonAttributes = [];
    private string $separator = "\n";

    public static function create(): self
    {
        return new self();
    }

    public function withoutContainer(): self
    {
        return $this->containerTag(null);
    }

    public function containerTag(?string $name): self
    {
        $new = clone $this;
        $new->containerTag = $name;
        return $new;
    }

    public function containerAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->containerAttributes = $attributes;
        return $new;
    }

    public function buttons(Button ...$buttons): self
    {
        $new = clone $this;
        $new->buttons = $buttons;
        return $new;
    }

    public function buttonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->buttonAttributes = array_merge($new->buttonAttributes, $attributes);
        return $new;
    }

    public function replaceButtonAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->buttonAttributes = $attributes;
        return $new;
    }

    public function disabled(?bool $disabled = true): self
    {
        $new = clone $this;
        $new->buttonAttributes['disabled'] = $disabled;
        return $new;
    }

    /**
     * Specifies the form element the buttons belongs to. The value of this attribute must be the ID attribute of a form
     * element in the same document.
     *
     * @param string|null $id ID of a form.
     *
     * @link https://html.spec.whatwg.org/multipage/form-control-infrastructure.html#attr-fae-form
     */
    public function form(?string $id): self
    {
        $new = clone $this;
        $new->buttonAttributes['form'] = $id;
        return $new;
    }

    public function separator(string $separator): self
    {
        $new = clone $this;
        $new->separator = $separator;
        return $new;
    }

    public function render(): string
    {
        if (empty($this->buttons)) {
            return '';
        }

        if (empty($this->buttonAttributes)) {
            $lines = $this->buttons;
        } else {
            $lines = [];
            foreach ($this->buttons as $button) {
                $lines[] = $button->unionAttributes($this->buttonAttributes);
            }
        }

        $html = [];
        if (!empty($this->containerTag)) {
            $html[] = Html::openTag($this->containerTag, $this->containerAttributes);
        }
        $html[] = implode($this->separator, $lines);
        if (!empty($this->containerTag)) {
            $html[] = Html::closeTag($this->containerTag);
        }

        return implode("\n", $html);
    }

    public function __toString(): string
    {
        return $this->render();
    }

    private function __construct()
    {
    }
}
