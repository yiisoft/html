<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Dd;
use Yiisoft\Html\Tag\Dl;
use Yiisoft\Html\Tag\Dt;

final class DlTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<dl><dt>Term</dt><dd>Definition</dd></dl>',
            (string) (new Dl())
                ->content(
                    (new Dt())->content('Term')
                    . (new Dd())->content('Definition'),
                )
                ->encode(false),
        );
    }
}
