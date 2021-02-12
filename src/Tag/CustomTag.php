<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\BaseNormalTag;

final class CustomTag extends BaseNormalTag
{
    private const TYPE_AUTO = 0;
    private const TYPE_NORMAL = 1;
    private const TYPE_VOID = 2;

    private int $type = self::TYPE_AUTO;

    /**
     * List of void elements. These only have a start tag; end tags must not be specified.
     *
     * {@see http://www.w3.org/TR/html-markup/syntax.html#void-element}
     */
    private const VOID_ELEMENTS = [
        'area' => 1,
        'base' => 1,
        'br' => 1,
        'col' => 1,
        'command' => 1,
        'embed' => 1,
        'hr' => 1,
        'img' => 1,
        'input' => 1,
        'keygen' => 1,
        'link' => 1,
        'meta' => 1,
        'param' => 1,
        'source' => 1,
        'track' => 1,
        'wbr' => 1,
    ];

    private string $name;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @psalm-param non-empty-string $name
     *
     * @return static
     */
    public static function name(string $name): self
    {
        return new self($name);
    }

    public function normal(): self
    {
        $new = clone $this;
        $new->type = self::TYPE_NORMAL;
        return $new;
    }

    public function void(): self
    {
        $new = clone $this;
        $new->type = self::TYPE_VOID;
        return $new;
    }

    protected function getName(): string
    {
        return $this->name;
    }

    public function render(): string
    {
        $isVoid = $this->type === self::TYPE_VOID ||
            ($this->type === self::TYPE_AUTO && isset(self::VOID_ELEMENTS[strtolower($this->name)]));
        return $isVoid ? $this->begin() : ($this->begin() . $this->generateContent() . $this->end());
    }
}
