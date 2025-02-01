<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mi;
use Yiisoft\Html\Tag\MathML\Mn;
use Yiisoft\Html\Tag\MathML\Msub;

final class MsubTest extends TestCase
{
    public function testSimple(): void
    {
        $msub = Msub::tag()
            ->items(
                Mi::tag()->identifier('X'),
                Mn::tag()->value(1),
            );

        $this->assertSame(
            '<msub>' . "\n" .
            '<mi>X</mi>' . "\n" .
            '<mn>1</mn>' . "\n" .
            '</msub>',
            (string) $msub
        );
    }
}
