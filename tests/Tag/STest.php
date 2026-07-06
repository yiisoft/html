<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\S;

final class STest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<s class="red">Hello</s>',
            (string) (new S())
                ->class('red')
                ->content('Hello'),
        );
    }
}
