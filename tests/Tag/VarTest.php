<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\VarTag;

final class VarTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<var class="red">Hello</var>',
            (string) (new VarTag())
                ->class('red')
                ->content('Hello'),
        );
    }

    public function testImmutability(): void
    {
        $tag = new VarTag();
        $this->assertNotSame($tag, $tag->content(''));
    }
}
