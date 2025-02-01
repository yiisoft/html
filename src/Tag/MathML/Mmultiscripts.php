<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\MathML;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://developer.mozilla.org/en-US/docs/Web/MathML/Element/mmultiscripts
 */
final class Mmultiscripts extends NormalTag implements MathItemInterface
{
    private MathItemInterface $base;
    private Mprescripts|null $mprescripts = null;

    /**
     * @var MathItemInterface[]
     */
    private array $post = [];

    /**
     * @var MathItemInterface[]
     */
    private array $pre = [];

    protected function getName(): string
    {
        return 'mmultiscripts';
    }

    protected function generateContent(): string
    {
        $content = "\n" . $this->base . "\n" . implode("\n", $this->post) . "\n";

        if ($this->pre) {
            $mprescripts = $this->mprescripts ?? Mprescripts::tag();
            $content .= $mprescripts . "\n" . implode("\n", $this->pre) . "\n";
        }

        return $content;
    }

    public function base(MathItemInterface $base): self
    {
        $new = clone $this;
        $new->base = $base;

        return $new;
    }

    public function post(MathItemInterface $item, MathItemInterface ...$items): self
    {
        $new = clone $this;
        $new->post = [$item];

        if ($items) {
            $new->post = [...$new->post, ...$items];
        }

        return $new;
    }

    public function pre(MathItemInterface ...$items): self
    {
        $new = clone $this;
        $new->pre = $items;

        return $new;
    }

    public function mprescripts(Mprescripts|null $mprescripts): self
    {
        $new = clone $this;
        $new->mprescripts = $mprescripts;

        return $new;
    }
}
