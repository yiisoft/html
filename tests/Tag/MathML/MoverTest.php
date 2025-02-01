<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mi;
use Yiisoft\Html\Tag\MathML\Mo;
use Yiisoft\Html\Tag\MathML\Mover;
use Yiisoft\Html\Tag\MathML\Mrow;

final class MoverTest extends TestCase
{
    public static function accentDataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @dataProvider accentDataProvider
     */
    public function testMover(bool $accent): void
    {
        $mover = Mover::tag()
            ->accent($accent)
            ->items(
                Mrow::tag()
                    ->items(
                        Mi::tag()->identifier('x'),
                        Mo::tag()->operator('+'),
                        Mi::tag()->identifier('y'),
                        Mo::tag()->operator('+'),
                        Mi::tag()->identifier('z'),
                    ),
                Mo::tag()->operator('&#x23DE;'),
            );

        $this->assertSame(
            '<mover accent="' . ($accent ? 'true' : 'false')  . '">' . "\n" .
            '<mrow>' . "\n" .
            '<mi>x</mi>' . "\n" .
            '<mo>+</mo>' . "\n" .
            '<mi>y</mi>' . "\n" .
            '<mo>+</mo>' . "\n" .
            '<mi>z</mi>' . "\n" .
            '</mrow>' . "\n" .
            '<mo>&#x23DE;</mo>' . "\n" .
            '</mover>',
            (string) $mover
        );
    }
}
