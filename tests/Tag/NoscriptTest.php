<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Noscript;

final class NoscriptTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<noscript><img src="pixel.png"></noscript>',
            (string) Noscript::tag()->content(Img::tag()->src('pixel.png')),
        );
    }
}
