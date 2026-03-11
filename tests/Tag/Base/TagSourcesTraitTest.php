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
            (new TestTagSourcesTrait())
                ->sources((new Source())->src('video1.mp4'))
                ->addSource((new Source())->src('video2.mp4'))
                ->addSource((new Source())->src('video3.mp4'))
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = new TestTagSourcesTrait();
        $this->assertNotSame($tag, $tag->sources());
        $this->assertNotSame($tag, $tag->addSource(new Source()));
    }
}
