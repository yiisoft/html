<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\H1;
use Yiisoft\Html\Tag\H2;
use Yiisoft\Html\Tag\H3;
use Yiisoft\Html\Tag\Hgroup;

final class HgroupTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<hgroup><h1>Heading 1</h1><h2>Heading 2</h2><h3>Heading 3</h3></hgroup>',
            (string) Hgroup::tag()->content(
                H1::tag()->content('Heading 1')
                . H2::tag()->content('Heading 2')
                . H3::tag()->content('Heading 3')
            )->encode(false)
        );
    }
}
