<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

final class A extends NormalTag
{
    public function href(?string $href): self
    {
        $new = clone $this;
        $new->attributes['href'] = $href;
        return $new;
    }

    public function url(?string $url): self
    {
        return $this->href($url);
    }

    public function mailto(?string $mail): self
    {
        return $this->href($mail === null ? null : 'mailto:' . $mail);
    }

    protected function getName(): string
    {
        return 'a';
    }
}
