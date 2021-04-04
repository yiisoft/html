<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

/**
 * Adds functionality for processing with tag content.
 */
trait TagContentTrait
{
    private ?bool $encode = null;
    private bool $doubleEncode = true;

    /**
     * @psalm-var list<string|Stringable>
     */
    private array $content = [];

    /**
     * @param bool|null $encode Whether to encode tag content. Supported values:
     *  - `null`: stringable objects that implement interface {@see NoEncodeStringableInterface} are not encoded,
     *    everything else is encoded;
     *  - `true`: any content is encoded;
     *  - `false`: nothing is encoded.
     * Defaults to `null`.
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
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    final public function content(...$content): self
    {
        $new = clone $this;
        $new->content = array_values($content);
        return $new;
    }

    /**
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    final public function addContent(...$content): self
    {
        $new = clone $this;
        $new->content = array_merge($new->content, array_values($content));
        return $new;
    }

    /**
     * @return string Obtain tag content considering encoding options {@see encode()}.
     */
    final protected function generateContent(): string
    {
        $content = '';

        foreach ($this->content as $item) {
            if ($this->encode || ($this->encode === null && !($item instanceof NoEncodeStringableInterface))) {
                $item = Html::encode($item, $this->doubleEncode);
            }

            $content .= $item;
        }

        return $content;
    }
}
