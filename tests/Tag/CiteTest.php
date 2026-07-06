<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Cite;

final class CiteTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<cite class="red">Hello</cite>',
            (string) (new Cite())
                ->class('red')
                ->content('Hello'),
        );
    }
}
