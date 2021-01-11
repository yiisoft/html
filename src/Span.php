<?php

declare(strict_types=1);

namespace Yiisoft\Html;

final class Span
{
    private string $content = '';
    private array $attributes = [];

    public function withContent(string $content): self
    {
        $new = clone $this;
        $new->content = $content;
        return $new;
    }

    public function withClass(string $class): self
    {
        $new = clone $this;
        $new->attributes['class'] = $class;
        return $new;
    }

    public function withId(string $id): self
    {
        $new = clone $this;
        $new->attributes['id'] = $id;
        return $new;
    }

    public function withData(array $data): self
    {
        $new = clone $this;
        $new->attributes['data'] = $data;
        return $new;
    }

    public function __toString(): string
    {
        return Html::tag('span', $this->content, $this->attributes);
    }
}
