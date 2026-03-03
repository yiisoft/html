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
            (string) new Hgroup()
                ->content(
                    new H1()->content('Heading 1')
                    . new H2()->content('Heading 2')
                    . new H3()->content('Heading 3'),
                )
                ->encode(false),
        );
    }
}
