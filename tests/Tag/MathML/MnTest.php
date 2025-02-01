<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\MathML\Mn;

final class MnTest extends TestCase
{
    public static function valueDataProvider(): array
    {
        return [
            ['10'],
            [12],
            [3.14],
            [
                new class () {
                    public function __toString()
                    {
                        return '2e10';
                    }
                }
            ]
        ];
    }

    /**
     * @dataProvider valueDataProvider
     */
    public function testValue(string|int|float|Stringable $value): void
    {
        $mn = Mn::tag()->value($value);

        $this->assertSame('<mn>' . $value . '</mn>', (string) $mn);
    }
}
