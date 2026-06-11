<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Area;

final class AreaTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<area>',
            (string) new Area(),
        );
    }

    public function testAlt(): void
    {
        $this->assertSame(
            '<area alt="Example">',
            (string) (new Area())->alt('Example'),
        );
    }

    public function testCoords(): void
    {
        $this->assertSame(
            '<area coords="10,20,30,40">',
            (string) (new Area())->coords('10,20,30,40'),
        );
    }

    public function testDownload(): void
    {
        $this->assertSame(
            '<area download="file.txt">',
            (string) (new Area())->download('file.txt'),
        );
    }

    public function testHref(): void
    {
        $this->assertSame(
            '<area href="https://example.com">',
            (string) (new Area())->href('https://example.com'),
        );
    }

    public function testHreflang(): void
    {
        $this->assertSame(
            '<area hreflang="en">',
            (string) (new Area())->hreflang('en'),
        );
    }

    public function testMedia(): void
    {
        $this->assertSame(
            '<area media="screen">',
            (string) (new Area())->media('screen'),
        );
    }

    public function testReferrerpolicy(): void
    {
        $this->assertSame(
            '<area referrerpolicy="no-referrer">',
            (string) (new Area())->referrerpolicy('no-referrer'),
        );
    }

    public function testRel(): void
    {
        $this->assertSame(
            '<area rel="nofollow">',
            (string) (new Area())->rel('nofollow'),
        );
    }

    public function testShape(): void
    {
        $this->assertSame(
            '<area shape="rect">',
            (string) (new Area())->shape('rect'),
        );
    }

    public function testTarget(): void
    {
        $this->assertSame(
            '<area target="_blank">',
            (string) (new Area())->target('_blank'),
        );
    }

    public function testType(): void
    {
        $this->assertSame(
            '<area type="text/html">',
            (string) (new Area())->type('text/html'),
        );
    }
}
