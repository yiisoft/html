<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Html;

final class LiTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<li class="red">Hello</li>',
            (string) Li::tag()
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testWithAttributes(): void
    {
        $this->assertSame(
            '<li class="item" id="item-1">Content</li>',
            (string) Html::li('Content', ['class' => 'item', 'id' => 'item-1']),
        );
    }

    public function testWithoutAttributes(): void
    {
        $this->assertSame(
            '<li>Content</li>',
            (string) Html::li('Content'),
        );
    }

    public function testEmptyContentWithAttributes(): void
    {
        $this->assertSame(
            '<li class="empty"></li>',
            (string) Html::li('', ['class' => 'empty']),
        );
    }

    public function testEmptyContentWithoutAttributes(): void
    {
        $this->assertSame(
            '<li></li>',
            (string) Html::li(),
        );
    }
}