<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input\Color;

final class ColorTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<input name="color" value="#ff0000" type="color">',
            Color::tag()
                ->name('color')
                ->value('#ff0000')
                ->render(),
        );
    }
}
