<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Source;
use Yiisoft\Html\Tests\Objects\TestTagSourcesTrait;

class TagSourcesTraitTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            "<test>\n<source src=\"video1.mp4\">\n<source src=\"video2.mp4\">\n<source src=\"video3.mp4\">\n</test>",
            TestTagSourcesTrait::tag()
                ->sources(Source::tag()->src('video1.mp4'))
                ->addSource(Source::tag()->src('video2.mp4'))
                ->addSource(Source::tag()->src('video3.mp4'))
                ->render()
        );
    }

    public function testImmutability(): void
    {
        $tag = TestTagSourcesTrait::tag();
        $this->assertNotSame($tag, $tag->sources());
        $this->assertNotSame($tag, $tag->addSource(Source::tag()));
    }
}
