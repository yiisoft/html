<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H1;
use Yiisoft\Html\Tag\Header;
use Yiisoft\Html\Tag\I;

final class HeaderTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<header><h1>Heading 1</h1><i>Hello Text</i></header>',
            (string) new Header()
                ->content(
                    new H1()->content('Heading 1')
                    . new I()->content('Hello Text'),
                )
                ->encode(false),
        );
    }
}
