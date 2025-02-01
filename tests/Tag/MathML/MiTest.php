<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\MathML\Mi;

final class MiTest extends TestCase
{
    public static function identifierDataProvider(): array
    {
        return [
            [
                new class () {
                    public function __toString()
                    {
                        return 'sin';
                    }
                }
            ],
            ['A'],
            ['𝔅'],
        ];
    }

    /**
     * @dataProvider identifierDataProvider
     */
    public function testIdentifier(string|Stringable $identifier): void
    {
        $mi = Mi::tag()->identifier($identifier);

        $this->assertSame('<mi>' . $identifier . '</mi>', (string) $mi);
    }

    public static function normalDataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @dataProvider normalDataProvider
     */
    public function testNormal(bool $normal): void
    {
        $mi = Mi::tag()
            ->normal($normal)
            ->identifier('F');

        if ($normal) {
            $this->assertSame('<mi mathvariant="normal">F</mi>', (string) $mi);
        } else {
            $this->assertSame('<mi>F</mi>', (string) $mi);
        }
    }
}
