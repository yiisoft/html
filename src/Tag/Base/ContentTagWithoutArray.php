<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

final class ContentTagWithoutArray extends NormalTag
{
    private ?bool $encode = null;
    private bool $doubleEncode = true;

    private string $content = '';

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
     * @param string|Stringable $content Tag content.
     *
     * @return static
     */
    public function content($content): self
    {
        $new = clone $this;
        $new->content = (string)$content;
        return $new;
    }

    /**
     * @return string Obtain tag content considering encoding options.
     */
    protected function generateContent(): string
    {
        $content = $this->content;

        if ($this->encode ||
            ($this->encode === null && !($content instanceof NoEncodeStringableInterface))
        ) {
            $content = Html::encode($content, $this->doubleEncode);
        }

        return $content;
    }

    protected function getName(): string
    {
        return 'test';
    }
}
