<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

/**
 * Adds functionality for encoding tag content.
 */
trait ContentEncodingTrait
{
    private ?bool $encode = null;
    private bool $doubleEncode = true;

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
     * Encodes content considering encoding options {@see encode()}.
     *
     * @param string|Stringable $content Tag content.
     *
     * @return string Encoded content considering encoding options.
     */
    final protected function encodeContent($content): string
    {
        if ($this->encode || ($this->encode === null && !($content instanceof NoEncodeStringableInterface))) {
            return Html::encode($content, $this->doubleEncode);
        }

        return (string) $content;
    }
}
