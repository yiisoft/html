<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag\Media;

use Yiisoft\Html\Tag\Base\VoidTag;

final class Track extends VoidTag
{
    public function default(bool $default = true): self
    {
        return $this->attribute('default', $default);
    }

    public function kind(string $kind): self
    {
        return $this->attribute('kind', $kind);
    }

    public function label(?string $label): self
    {
        return $this->attribute('label', $label);
    }

    public function src(string $src): self
    {
        return $this->attribute('src', $src);
    }

    public function srclang(?string $srclang): self
    {
        return $this->attribute('srclang', $srclang);
    }

    protected function getName(): string
    {
        return 'track';
    }
}
