<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Base;

use Stringable;

abstract class ContentTag extends NormalTag
{
    use ContentEncodingTrait;

    /**
     * @var string[]|Stringable[]
     */
    private array $content = [];

    /**
     * @param string|Stringable ...$content Tag content.
     *
     * @return static
     */
    final public function content(...$content): self
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
        $new->content = [...$new->content, ...$content];
        return $new;
    }

    /**
     * @return string Obtain tag content considering encoding options.
     */
    final protected function generateContent(): string
    {
        $content = '';

        foreach ($this->content as $item) {
            $content .= $this->encodeContent($item);
        }

        return $content;
    }
}
