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
        $tag = (new TestListTag())->items(
            (new Li())->content('A'),
            (new Li())->content('B'),
        );

        $this->assertSame("<test>\n<li>A</li>\n<li>B</li>\n</test>", (string) $tag);
    }

    public function testStrings(): void
    {
        $tag = (new TestListTag())->strings(['A', 'B', 1, 2.5, null]);

        $this->assertSame("<test>\n<li>A</li>\n<li>B</li>\n<li>1</li>\n<li>2.5</li>\n<li></li>\n</test>", (string) $tag);
    }

    public function testStringsAttributes(): void
    {
        $tag = (new TestListTag())->strings(['A', 'B'], ['class' => 'red']);

        $this->assertSame(
            "<test>\n<li class=\"red\">A</li>\n<li class=\"red\">B</li>\n</test>",
            (string) $tag,
        );
    }

    public function testStringsEncode(): void
    {
        $tag = (new TestListTag())->strings(['<b>A</b>', '<b>B</b>']);

        $this->assertSame(
            "<test>\n<li>&lt;b&gt;A&lt;/b&gt;</li>\n<li>&lt;b&gt;B&lt;/b&gt;</li>\n</test>",
            (string) $tag,
        );
    }

    public function testStringsWithoutEncode(): void
    {
        $tag = (new TestListTag())->strings(['<b>A</b>', '<b>B</b>'], [], false);

        $this->assertSame("<test>\n<li><b>A</b></li>\n<li><b>B</b></li>\n</test>", (string) $tag);
    }

    public function testImmutability(): void
    {
        $tag = new TestListTag();
        $this->assertNotSame($tag, $tag->items());
        $this->assertNotSame($tag, $tag->strings([]));
    }
}
