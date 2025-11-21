<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Em;

final class EmTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<em class="red">Hello</em>',
            (string) Em::tag()
                ->class('red')
                ->content('Hello'),
        );
    }
}
