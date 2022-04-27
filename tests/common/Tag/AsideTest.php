<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Aside;
use Yiisoft\Html\Tag\H2;
use Yiisoft\Html\Tag\P;

final class AsideTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<aside><h2>Hello</h2><p>Aside Tag Content</p></aside>',
            (string) Aside::tag()->content(
                H2::tag()->content('Hello')
                . P::tag()->content('Aside Tag Content')
            )->encode(false)
        );
    }
}
