<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;
use Yiisoft\Html\Html;
use Yiisoft\Html\NoEncodeStringableInterface;

final class ContentTagArrayMap extends NormalTag
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

    /**
     * @return string Obtain tag content considering encoding options.
     */
    protected function generateContent(): string
    {
        $content = array_map(function ($item) {
            if ($this->encode ||
                ($this->encode === null && !($item instanceof NoEncodeStringableInterface))
            ) {
                $item = Html::encode($item, $this->doubleEncode);
            }

            return $item;
        }, $this->content);

        return implode('', $content);
    }

    protected function getName(): string
    {
        return 'test';
    }
}
