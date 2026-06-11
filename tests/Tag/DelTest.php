<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Del;
use Yiisoft\Html\Tag\P;

final class DelTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<del><p>Removed</p></del>',
            (string) (new Del())
                ->content(
                    (new P())->content('Removed'),
                ),
        );
    }

    public function testCite(): void
    {
        $this->assertSame(
            '<del cite="https://example.com"><p>Removed</p></del>',
            (string) (new Del())
                ->cite('https://example.com')
                ->content(
                    (new P())->content('Removed'),
                ),
        );
    }

    public function testDatetime(): void
    {
        $this->assertSame(
            '<del datetime="2024-01-01"><p>Removed</p></del>',
            (string) (new Del())
                ->datetime('2024-01-01')
                ->content(
                    (new P())->content('Removed'),
                ),
        );
    }
}
