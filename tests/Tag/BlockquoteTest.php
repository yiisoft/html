<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Blockquote;
use Yiisoft\Html\Tag\P;

final class BlockquoteTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<blockquote><p>Quote</p></blockquote>',
            (string) (new Blockquote())
                ->content(
                    (new P())->content('Quote'),
                ),
        );
    }

    public function testCite(): void
    {
        $this->assertSame(
            '<blockquote cite="https://example.com"><p>Quote</p></blockquote>',
            (string) (new Blockquote())
                ->cite('https://example.com')
                ->content(
                    (new P())->content('Quote'),
                ),
        );
    }
}
