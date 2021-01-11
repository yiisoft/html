<?php

declare(strict_types=1);

namespace Yiisoft\Html;

final class SpanNoClone
{
    private string $content = '';
    private array $attributes = [];

    public function withContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function withClass(string $class): self
    {
        $this->attributes['class'] = $class;
        return $this;
    }

    public function withId(string $id): self
    {
        $this->attributes['id'] = $id;
        return $this;
    }

    public function withData(array $data): self
    {
        $this->attributes['data'] = $data;
        return $this;
    }

    public function __toString(): string
    {
        return Html::tag('span', $this->content, $this->attributes);
    }
}
