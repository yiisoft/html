<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Iframe;

final class IframeTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<iframe></iframe>',
            (string) (new Iframe()),
        );
    }

    public function testSrc(): void
    {
        $this->assertSame(
            '<iframe src="https://example.com"></iframe>',
            (string) (new Iframe())->src('https://example.com'),
        );
    }
}
