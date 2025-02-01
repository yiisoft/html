<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mfrac;
use Yiisoft\Html\Tag\MathML\Mi;

final class MfracTest extends TestCase
{
    public static function barDataProvider(): array
    {
        return [
            [
                '25%',
                'linethickness="25%"',
            ],
            [
                '0',
                'linethickness="0"',
            ],
            [
                null,
                null,
            ]
        ];
    }

    /**
     * @dataProvider barDataProvider
     */
    public function testBar(string|int|null $height, string|null $expected): void
    {
        $mfrac = Mfrac::tag()
            ->linethickness($height)
            ->items(
                Mi::tag()->identifier('n'),
            );

        if ($expected) {
            self::assertStringContainsString($expected, (string) $mfrac);
        } else {
            self::assertStringNotContainsString('linethickness=', (string) $mfrac);
        }
    }
}
