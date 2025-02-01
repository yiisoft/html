<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mi;
use Yiisoft\Html\Tag\MathML\Mo;
use Yiisoft\Html\Tag\MathML\Mrow;
use Yiisoft\Html\Tag\MathML\Munder;

final class MunderTest extends TestCase
{
    public static function accentunderDataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @dataProvider accentunderDataProvider
     */
    public function testMunder(bool $accentunder): void
    {
        $mover = Munder::tag()
            ->accentunder($accentunder)
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
            '<munder accentunder="' . ($accentunder ? 'true' : 'false')  . '">' . "\n" .
            '<mrow>' . "\n" .
            '<mi>x</mi>' . "\n" .
            '<mo>+</mo>' . "\n" .
            '<mi>y</mi>' . "\n" .
            '<mo>+</mo>' . "\n" .
            '<mi>z</mi>' . "\n" .
            '</mrow>' . "\n" .
            '<mo>&#x23DE;</mo>' . "\n" .
            '</munder>',
            (string) $mover
        );
    }
}
