<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Title;

final class TitleTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<title>Hello, World!</title>',
            (string) Title::tag()->content('Hello, World!'),
        );
    }
}
