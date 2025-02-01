<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mn;
use Yiisoft\Html\Tag\MathML\Mo;
use Yiisoft\Html\Tag\MathML\Msubsup;

final class MsubsupTest extends TestCase
{
    public function testSimple(): void
    {
        $msubsup = Msubsup::tag()
            ->items(
                Mo::tag()->operator('&#x222B;'),
                Mn::tag()->value(0),
                Mn::tag()->value(1),
            );

        $this->assertSame(
            '<msubsup>' . "\n" .
            '<mo>&#x222B;</mo>' . "\n" .
            '<mn>0</mn>' . "\n" .
            '<mn>1</mn>' . "\n" .
            '</msubsup>',
            (string) $msubsup
        );
    }
}
