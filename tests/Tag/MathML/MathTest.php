<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Math;
use Yiisoft\Html\Tag\MathML\Mfrac;
use Yiisoft\Html\Tag\MathML\Mi;
use Yiisoft\Html\Tag\MathML\Mn;
use Yiisoft\Html\Tag\MathML\Mo;
use Yiisoft\Html\Tag\MathML\Mrow;
use Yiisoft\Html\Tag\MathML\Msup;
use Yiisoft\Html\Tag\MathML\Munderover;

final class MathTest extends TestCase
{
    public function testBlock(): void
    {
        $math = Math::tag()
            ->block()
            ->items(
                Mrow::tag()
                    ->items(
                        Munderover::tag()
                            ->items(
                                Mo::tag()->operator('∑'),
                                Mrow::tag()
                                    ->items(
                                        Mi::tag()->identifier('n'),
                                        Mo::tag()->operator('='),
                                        Mn::tag()->value(1),
                                    ),
                                Mrow::tag()
                                    ->items(
                                        Mo::tag()->operator('+'),
                                        Mn::tag()->value('∞'),
                                    )
                            ),
                        Mfrac::tag()
                            ->items(
                                Mn::tag()->value(1),
                                Msup::tag()
                                    ->items(
                                        Mi::tag()->identifier('n'),
                                        Mn::tag()->value(2),
                                    )
                            )
                    )
            );

        $this->assertSame(
            '<math display="block">' . "\n" .
            '<mrow>' . "\n" .
            '<munderover>'  . "\n" .
            '<mo>∑</mo>' . "\n" .
            '<mrow>' . "\n" .
            '<mi>n</mi>' . "\n" .
            '<mo>=</mo>' . "\n" .
            '<mn>1</mn>' . "\n" .
            '</mrow>' . "\n" .
            '<mrow>' . "\n" .
            '<mo>+</mo>' . "\n" .
            '<mn>∞</mn>' . "\n" .
            '</mrow>' . "\n" .
            '</munderover>' . "\n" .
            '<mfrac>' . "\n" .
            '<mn>1</mn>' . "\n" .
            '<msup>' . "\n" .
            '<mi>n</mi>' . "\n" .
            '<mn>2</mn>' . "\n" .
            '</msup>' . "\n" .
            '</mfrac>' . "\n" .
            '</mrow>' . "\n" .
            '</math>',
            (string) $math
        );
    }

    public function testInline(): void
    {
        $math = Math::tag()
            ->inline()
            ->items(
                Mfrac::tag()
                    ->items(
                        Msup::tag()
                            ->items(
                                Mi::tag()->identifier('π'),
                                Mn::tag()->value(2),
                            ),
                        Mn::tag()->value(6)
                    )
            );

        $this->assertSame(
            '<math>' . "\n" .
            '<mfrac>' . "\n" .
            '<msup>' . "\n" .
            '<mi>π</mi>' . "\n" .
            '<mn>2</mn>' . "\n" .
            '</msup>'. "\n" .
            '<mn>6</mn>' . "\n" .
            '</mfrac>' . "\n" .
            '</math>',
            (string) $math
        );
    }
}
