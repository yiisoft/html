<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tests\Objects\TestListTag;

final class ListTagTest extends TestCase
{
    public function testItems(): void
    {
        $tag = TestListTag::tag()->items(
            Li::tag()->content('A'),
            Li::tag()->content('B')
        );

        $this->assertSame("<test>\n<li>A</li>\n<li>B</li>\n</test>", (string)$tag);
    }

    public function testStrings(): void
    {
        $tag = TestListTag::tag()->strings(['A', 'B']);

        $this->assertSame("<test>\n<li>A</li>\n<li>B</li>\n</test>", (string)$tag);
    }

    public function testStringsEncode(): void
    {
        $tag = TestListTag::tag()->strings(['<b>A</b>', '<b>B</b>']);

        $this->assertSame(
            "<test>\n<li>&lt;b&gt;A&lt;/b&gt;</li>\n<li>&lt;b&gt;B&lt;/b&gt;</li>\n</test>",
            (string)$tag
        );
    }

    public function testStringsWithoutEncode(): void
    {
        $tag = TestListTag::tag()->strings(['<b>A</b>', '<b>B</b>'], false);

        $this->assertSame("<test>\n<li><b>A</b></li>\n<li><b>B</b></li>\n</test>", (string)$tag);
    }
}
