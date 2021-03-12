<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Base\NotEncodeStringableInterface;
use Yiisoft\Html\Tag\Base\Tag;

/**
 * Custom HTML tag.
 */
final class CustomTag extends Tag
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
    private ?bool $encode = null;
    private bool $doubleEncode = true;

    /**
     * @var string[]|Stringable[]
     */
    private array $content = [];

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Create a tag instance with the name provided.
     *
     * @param string $name Name of the tag.
     *
     * @psalm-param non-empty-string $name
     *
     * @return self
     */
    public static function name(string $name): self
    {
        return new self($name);
    }

    /**
     * Set type of the tag as normal.
     * Normal tags have both open and close parts.
     *
     * @return self
     */
    public function normal(): self
    {
        $new = clone $this;
        $new->type = self::TYPE_NORMAL;
        return $new;
    }

    /**
     * Set type of the tag as void.
     * Void tags should be self-closed right away.
     *
     * @return self
     */
    public function void(): self
    {
        $new = clone $this;
        $new->type = self::TYPE_VOID;
        return $new;
    }

    /**
     * @param bool|null $encode Whether to encode tag content. Defaults to `null`.
     *
     * @return static
     */
    public function encode(?bool $encode): self
    {
        $new = clone $this;
        $new->encode = $encode;
        return $new;
    }

    /**
     * @param bool $doubleEncode Whether already encoded HTML entities in tag content should be encoded.
     * Defaults to `true`.
     *
     * @return static
     */
    public function doubleEncode(bool $doubleEncode): self
    {
        $new = clone $this;
        $new->doubleEncode = $doubleEncode;
        return $new;
    }

    /**
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    public function content(...$content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    /**
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    public function addContent(...$content): self
    {
        $new = clone $this;
        $new->content = array_merge($new->content, $content);
        return $new;
    }

    protected function getName(): string
    {
        return $this->name;
    }

    protected function renderTag(): string
    {
        $isVoid = $this->type === self::TYPE_VOID ||
            ($this->type === self::TYPE_AUTO && isset(self::VOID_ELEMENTS[strtolower($this->name)]));
        return $isVoid ? $this->open() : ($this->open() . $this->generateContent() . $this->close());
    }

    /**
     * @return string Opening tag.
     */
    public function open(): string
    {
        return '<' . $this->getName() . $this->renderAttributes() . '>';
    }

    /**
     * @return string Closing tag.
     */
    public function close(): string
    {
        return '</' . $this->getName() . '>';
    }

    /**
     * @return string Obtain tag content considering encoding options.
     */
    private function generateContent(): string
    {
        $content = array_map(function ($item) {
            if ($this->encode ||
                ($this->encode === null && !($item instanceof NotEncodeStringableInterface))
            ) {
                $item = Html::encode($item, $this->doubleEncode);
            }

            return $item;
        }, $this->content);

        return implode('', $content);
    }
}
