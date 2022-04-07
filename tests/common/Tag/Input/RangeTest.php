<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input\Range;
use Yiisoft\Html\Tests\Objects\StringableObject;

final class RangeTest extends TestCase
{
    public function testBase(): void
    {
        $tag = Range::tag()
            ->name('opacity')
            ->min(0)
            ->max(100)
            ->step(10);

        $this->assertSame(
            '<input type="range" name="opacity" min="0" max="100" step="10">',
            $tag->render()
        );
    }

    public function dataMin(): array
    {
        return [
            ['<input type="range">', null],
            ['<input type="range" min>', ''],
            ['<input type="range" min="2.5">', '2.5'],
            ['<input type="range" min="10">', 10],
            ['<input type="range" min="42.7">', 42.7],
            ['<input type="range" min="99">', new StringableObject('99')],
        ];
    }

    /**
     * @dataProvider dataMin
     */
    public function testMin(string $expected, $value): void
    {
        $tag = Range::tag()->min($value);

        $this->assertSame($expected, $tag->render());
    }

    public function dataMax(): array
    {
        return [
            ['<input type="range">', null],
            ['<input type="range" max>', ''],
            ['<input type="range" max="2.5">', '2.5'],
            ['<input type="range" max="10">', 10],
            ['<input type="range" max="42.7">', 42.7],
            ['<input type="range" max="99">', new StringableObject('99')],
        ];
    }

    /**
     * @dataProvider dataMax
     */
    public function testMax(string $expected, $value): void
    {
        $tag = Range::tag()->max($value);

        $this->assertSame($expected, $tag->render());
    }

    public function dataStep(): array
    {
        return [
            ['<input type="range">', null],
            ['<input type="range" step>', ''],
            ['<input type="range" step="2.5">', '2.5'],
            ['<input type="range" step="10">', 10],
            ['<input type="range" step="42.7">', 42.7],
            ['<input type="range" step="99">', new StringableObject('99')],
        ];
    }

    /**
     * @dataProvider dataStep
     */
    public function testStep(string $expected, $value): void
    {
        $tag = Range::tag()->step($value);

        $this->assertSame($expected, $tag->render());
    }

    public function testImmutability(): void
    {
        $tag = Range::tag();

        $this->assertNotSame($tag, $tag->min(null));
        $this->assertNotSame($tag, $tag->max(null));
        $this->assertNotSame($tag, $tag->step(null));
    }
}
