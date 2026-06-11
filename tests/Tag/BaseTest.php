<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Base;

final class BaseTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<base>',
            (string) new Base(),
        );
    }

    public function testHref(): void
    {
        $this->assertSame(
            '<base href="https://example.com">',
            (string) (new Base())->href('https://example.com'),
        );
    }

    public function testTarget(): void
    {
        $this->assertSame(
            '<base target="_blank">',
            (string) (new Base())->target('_blank'),
        );
    }
}
