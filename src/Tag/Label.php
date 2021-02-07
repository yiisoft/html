<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

final class Label extends NormalTag
{
    public function forId(?string $id): self
    {
        $new = clone $this;
        $new->attributes['for'] = $id;
        return $new;
    }

    protected function getName(): string
    {
        return 'label';
    }
}
