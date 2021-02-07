<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

final class Textarea extends NormalTag
{
    public function name(?string $name): self
    {
        $new = clone $this;
        $new->attributes['name'] = $name;
        return $new;
    }

    public function rows(?int $count): self
    {
        $new = clone $this;
        $new->attributes['rows'] = $count;
        return $new;
    }

    public function columns(?int $count): self
    {
        $new = clone $this;
        $new->attributes['cols'] = $count;
        return $new;
    }

    public function value(?string $value): self
    {
        return $this->content($value === null ? '' : $value);
    }

    protected function getName(): string
    {
        return 'textarea';
    }
}