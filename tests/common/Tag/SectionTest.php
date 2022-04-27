<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H1;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Section;

final class SectionTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<section><h1>Section Heading</h1><p>Section Content</p></section>',
            (string) Section::tag()->content(
                H1::tag()->content('Section Heading')
                . P::tag()->content('Section Content')
            )->encode(false)
        );
    }
}
