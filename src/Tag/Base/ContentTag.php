<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Html;

use function is_array;

abstract class ContentTag extends NormalTag
{
    private ?bool $encode = null;
    private bool $doubleEncode = true;

    /**
     * @var string[]|Stringable[]
     */
    private array $content = [];

    /**
     * @param bool|null $encode Whether to encode tag content. Defaults to `null`.
     *
     * @return static
     */
    final public function encode(?bool $encode): self
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
    final public function doubleEncode(bool $doubleEncode): self
    {
        $new = clone $this;
        $new->doubleEncode = $doubleEncode;
        return $new;
    }

    /**
     * @param string|Stringable|string[]|Stringable[] $content Tag content.
     *
     * @return static
     */
    final public function content($content): self
    {
        $new = clone $this;
        $new->content = is_array($content) ? $content : [$content];
        return $new;
    }

    /**
     * @return string Obtain tag content considering encoding options.
     */
    final protected function generateContent(): string
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
