<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Data;

final class DataTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<data class="red">Hello</data>',
            (string) (new Data())
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testValue(): void
    {
        $this->assertSame(
            '<data value="42">Hello</data>',
            (string) (new Data())
                ->value('42')
                ->content('Hello'),
        );
    }

    public function testImmutability(): void
    {
        $tag = new Data();
        $this->assertNotSame($tag, $tag->value(null));
    }
}
