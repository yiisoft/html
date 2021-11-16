<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;

interface ContentTagInterface
{
    public function encode(?bool $encode): self;

    /**
     * @param bool $doubleEncode Whether already encoded HTML entities in tag content should be encoded.
     * Defaults to `true`.
     *
     * @return static
     */
    public function doubleEncode(bool $doubleEncode): self;

    /**
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    public function content(...$content): self;

    /**
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    public function addContent(...$content): self;

    public function getContent(): string;

    public function render(): string;

    /**
     * @return string Opening tag.
     */
    public function open(): string;

    /**
     * @return string Closing tag.
     */
    public function close(): string;
}
