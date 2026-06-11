<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Ins;
use Yiisoft\Html\Tag\P;

final class InsTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<ins><p>Added</p></ins>',
            (string) (new Ins())
                ->content(
                    (new P())->content('Added'),
                ),
        );
    }

    public function testCite(): void
    {
        $this->assertSame(
            '<ins cite="https://example.com"><p>Added</p></ins>',
            (string) (new Ins())
                ->cite('https://example.com')
                ->content(
                    (new P())->content('Added'),
                ),
        );
    }

    public function testDatetime(): void
    {
        $this->assertSame(
            '<ins datetime="2024-01-01"><p>Added</p></ins>',
            (string) (new Ins())
                ->datetime('2024-01-01')
                ->content(
                    (new P())->content('Added'),
                ),
        );
    }
}
