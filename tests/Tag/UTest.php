<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\U;

final class UTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<u class="red">Hello</u>',
            (string) (new U())
                ->class('red')
                ->content('Hello'),
        );
    }
}
