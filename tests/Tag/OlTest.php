<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ol;

final class OlTest extends TestCase
{
    public function testItems(): void
    {
        $ol = Ol::tag()->items(
            Li::tag()->content('A'),
            Li::tag()->content('B')
        );

        $this->assertSame("<ol>\n<li>A</li>\n<li>B</li>\n</ol>", (string)$ol);
    }

    public function testStrings(): void
    {
        $ol = Ol::tag()->strings(['A', 'B']);

        $this->assertSame("<ol>\n<li>A</li>\n<li>B</li>\n</ol>", (string)$ol);
    }

    public function testStringsEncode(): void
    {
        $ol = Ol::tag()->strings(['<b>A</b>', '<b>B</b>']);

        $this->assertSame("<ol>\n<li>&lt;b&gt;A&lt;/b&gt;</li>\n<li>&lt;b&gt;B&lt;/b&gt;</li>\n</ol>", (string)$ol);
    }

    public function testStringsWithoutEncode(): void
    {
        $ol = Ol::tag()->strings(['<b>A</b>', '<b>B</b>'], false);

        $this->assertSame("<ol>\n<li><b>A</b></li>\n<li><b>B</b></li>\n</ol>", (string)$ol);
    }
}
