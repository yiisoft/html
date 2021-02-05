<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ul;

final class UlTest extends TestCase
{
    public function testItems(): void
    {
        $ul = Ul::tag()->items(
            Li::tag()->content('A'),
            Li::tag()->content('B')
        );

        $this->assertSame("<ul>\n<li>A</li>\n<li>B</li>\n</ul>", (string)$ul);
    }

    public function testStrings(): void
    {
        $ul = Ul::tag()->strings(['A', 'B']);

        $this->assertSame("<ul>\n<li>A</li>\n<li>B</li>\n</ul>", (string)$ul);
    }

    public function testStringsEncode(): void
    {
        $ul = Ul::tag()->strings(['<b>A</b>', '<b>B</b>']);

        $this->assertSame("<ul>\n<li>&lt;b&gt;A&lt;/b&gt;</li>\n<li>&lt;b&gt;B&lt;/b&gt;</li>\n</ul>", (string)$ul);
    }

    public function testStringsWithoutEncode(): void
    {
        $ul = Ul::tag()->strings(['<b>A</b>', '<b>B</b>'], false);

        $this->assertSame("<ul>\n<li><b>A</b></li>\n<li><b>B</b></li>\n</ul>", (string)$ul);
    }
}
