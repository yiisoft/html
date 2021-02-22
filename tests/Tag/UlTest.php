<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;

final class UlTest extends TestCase
{
    public function testBase(): void
    {
        $ul = Ul::tag()->items(
            Li::tag()->content('A'),
            Li::tag()->content('B')
        );

        $this->assertSame("<ul>\n<li>A</li>\n<li>B</li>\n</ul>", (string)$ul);
    }
}
