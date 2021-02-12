<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input\Checkbox;

final class CheckboxTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<input type="checkbox" name="number" value="42">',
            Checkbox::tag()->name('number')->value(42)->render()
        );
    }
}
