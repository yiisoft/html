<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Input;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\InputTag;

/**
 * @link https://html.spec.whatwg.org/multipage/input.html#file-upload-state-(type=file)
 */
final class File extends InputTag
{
    private ?string $uncheckValue = null;
    private array $uncheckInputAttributes = [];

    /**
     * @param bool|float|int|string|Stringable|null $value
     */
    public function uncheckValue($value): self
    {
        $new = clone $this;
        $new->uncheckValue = $value === null ? null : (string) $value;
        return $new;
    }

    /**
     * @deprecated Use {@see addUncheckInputAttributes()} or {@see replaceUncheckInputAttributes()} instead. In the next
     * major version `replaceUncheckInputAttributes()` method will be renamed to `uncheckInputAttributes()`.
     */
    public function uncheckInputAttributes(array $attributes): self
    {
        return $this->addUncheckInputAttributes($attributes);
    }

    public function addUncheckInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->uncheckInputAttributes = array_merge($new->uncheckInputAttributes, $attributes);
        return $new;
    }

    public function replaceUncheckInputAttributes(array $attributes): self
    {
        $new = clone $this;
        $new->uncheckInputAttributes = $attributes;
        return $new;
    }

    /**
     * The accept attribute value is a string that defines the file types the file input should accept. This string is
     * a comma-separated list of unique file type specifiers. Because a given file type may be identified in more than
     * one manner, it's useful to provide a thorough set of type specifiers when you need files of a given format.
     *
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-accept
     */
    public function accept(?string $value): self
    {
        $new = clone $this;
        $new->attributes['accept'] = $value;
        return $new;
    }

    /**
     * @link https://html.spec.whatwg.org/multipage/input.html#attr-input-multiple
     *
     * @param bool $multiple Whether to allow selecting multiple files.
     */
    public function multiple(bool $multiple = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $multiple;
        return $new;
    }

    protected function prepareAttributes(): void
    {
        $this->attributes['type'] = 'file';
    }

    protected function before(): string
    {
        return $this->renderUncheckInput();
    }

    private function renderUncheckInput(): string
    {
        if ($this->uncheckValue === null) {
            return '';
        }

        $name = (string)($this->attributes['name'] ?? '');
        if (empty($name)) {
            return '';
        }

        $input = Html::hiddenInput(
            Html::getNonArrayableName($name),
            $this->uncheckValue,
            $this->uncheckInputAttributes
        );

        // Make sure disabled input is not sending any value.
        if (!empty($this->attributes['disabled'])) {
            $input = $input->attribute('disabled', $this->attributes['disabled']);
        }

        if (!empty($this->attributes['form'])) {
            $input = $input->attribute('form', $this->attributes['form']);
        }

        return $input->render();
    }
}
