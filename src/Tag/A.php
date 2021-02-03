<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class A extends ClosedTag
{
    public static function tag(): self
    {
        return new self();
    }

    public function url(?string $url): self
    {
        $new = clone $this;
        $new->attributes['href'] = $url;
        return $new;
    }

    protected function getName(): string
    {
        return 'a';
    }
}
