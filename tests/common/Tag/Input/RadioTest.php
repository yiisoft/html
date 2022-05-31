<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input\Radio;

final class RadioTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<input type="radio" name="number" value="42">',
            Radio::tag()
                ->name('number')
                ->value(42)
                ->render()
        );
    }
}
