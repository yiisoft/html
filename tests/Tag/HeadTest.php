<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Head;
use Yiisoft\Html\Tag\Meta;
use Yiisoft\Html\Tag\Title;

final class HeadTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<head><title>Page Title</title><meta charset="utf-8"></head>',
            (string) (new Head())
                ->content(
                    (new Title())->content('Page Title')
                    . (new Meta())->charset('utf-8'),
                )
                ->encode(false),
        );
    }
}
