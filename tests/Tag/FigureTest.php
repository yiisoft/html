<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Figcaption;
use Yiisoft\Html\Tag\Figure;
use Yiisoft\Html\Tag\P;

final class FigureTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<figure><figcaption>Caption</figcaption><p>Content</p></figure>',
            (string) (new Figure())
                ->content(
                    (new Figcaption())->content('Caption')
                    . (new P())->content('Content'),
                )
                ->encode(false),
        );
    }
}
