<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Dd;

final class DdTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<dd class="red">Hello</dd>',
            (string) (new Dd())
                ->class('red')
                ->content('Hello'),
        );
    }
}
