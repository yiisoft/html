<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
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
            '<input name="opacity" min="0" max="100" step="10" type="range">',
            $tag->render()
        );
    }

    public static function dataMin(): array
    {
        return [
            ['<input type="range">', null],
            ['<input min type="range">', ''],
            ['<input min="2.5" type="range">', '2.5'],
            ['<input min="10" type="range">', 10],
            ['<input min="42.7" type="range">', 42.7],
            ['<input min="99" type="range">', new StringableObject('99')],
        ];
    }

    #[DataProvider('dataMin')]
    public function testMin(string $expected, $value): void
    {
        $tag = Range::tag()->min($value);

        $this->assertSame($expected, $tag->render());
    }

    public static function dataMax(): array
    {
        return [
            ['<input type="range">', null],
            ['<input max type="range">', ''],
            ['<input max="2.5" type="range">', '2.5'],
            ['<input max="10" type="range">', 10],
            ['<input max="42.7" type="range">', 42.7],
            ['<input max="99" type="range">', new StringableObject('99')],
        ];
    }

    #[DataProvider('dataMax')]
    public function testMax(string $expected, $value): void
    {
        $tag = Range::tag()->max($value);

        $this->assertSame($expected, $tag->render());
    }

    public static function dataStep(): array
    {
        return [
            ['<input type="range">', null],
            ['<input step type="range">', ''],
            ['<input step="2.5" type="range">', '2.5'],
            ['<input step="10" type="range">', 10],
            ['<input step="42.7" type="range">', 42.7],
            ['<input step="99" type="range">', new StringableObject('99')],
        ];
    }

    #[DataProvider('dataStep')]
    public function testStep(string $expected, $value): void
    {
        $tag = Range::tag()->step($value);

        $this->assertSame($expected, $tag->render());
    }

    public static function dataList(): array
    {
        return [
            ['<input type="range">', null],
            ['<input list="DataList" type="range">', 'DataList'],
        ];
    }

    #[DataProvider('dataList')]
    public function testList(string $expected, $value): void
    {
        $tag = Range::tag()->list($value);

        $this->assertSame($expected, $tag->render());
    }

    public function testShowOutput(): void
    {
        $tag = Range::tag()->showOutput();

        $this->assertMatchesRegularExpression(
            '~<input type="range" '
            . 'oninput="document\.getElementById\(\&quot;(?<id>rangeOutput\d*)\&quot;\)\.innerHTML=this\.value">'
            . "\n" . '<span id="(?P=id)">-</span>~',
            $tag->render(),
        );
    }

    public function testAddOutputAttributes(): void
    {
        $tag = Range::tag()
            ->showOutput()
            ->addOutputAttributes(['class' => 'red'])
            ->addOutputAttributes(['id' => 'UID']);

        $this->assertSame(
            '<input type="range" ' .
            'oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">' .
            "\n" . '<span class="red" id="UID">-</span>',
            $tag->render()
        );
    }

    public function testReplaceOutputAttributes(): void
    {
        $tag = Range::tag()
            ->showOutput()
            ->addOutputAttributes(['class' => 'red'])
            ->outputAttributes(['id' => 'UID']);

        $this->assertSame(
            '<input type="range" '
            . 'oninput="document.getElementById(&quot;UID&quot;).innerHTML=this.value">'
            . "\n" . '<span id="UID">-</span>',
            $tag->render(),
        );
    }

    public function testOutputWithCustomId(): void
    {
        $tag = Range::tag()
            ->showOutput()
            ->outputAttributes(['id' => 'UID']);

        $this->assertMatchesRegularExpression(
            '~<input type="range" '
            . 'oninput="document.getElementById\(\&quot;UID\&quot;\)\.innerHTML=this\.value">'
            . "\n" . '<span id="UID">-</span>~',
            $tag->render(),
        );
    }

    public function testOutputWithCustomTag(): void
    {
        $tag = Range::tag()
            ->showOutput()
            ->outputTag('b');

        $this->assertMatchesRegularExpression(
            '~<input type="range" '
            . 'oninput="document\.getElementById\(\&quot;(?<id>rangeOutput\d*)\&quot;\)\.innerHTML=this\.value">'
            . "\n" . '<b id="(?P=id)">-</b>~',
            $tag->render(),
        );
    }

    public function testOutputWithCustomAttributes(): void
    {
        $tag = Range::tag()
            ->showOutput()
            ->outputAttributes(['class' => 'red']);

        $this->assertMatchesRegularExpression(
            '~<input type="range" ' .
            'oninput="document\.getElementById\(\&quot;(?<id>rangeOutput\d*)\&quot;\)\.innerHTML=this\.value">' .
            "\n" . '<span class="red" id="(?P=id)">-</span>~',
            $tag->render()
        );
    }

    public function testOutputWithValue(): void
    {
        $tag = Range::tag()
            ->showOutput()
            ->value(10);

        $this->assertMatchesRegularExpression(
            '~<input value="10" type="range" ' .
            'oninput="document\.getElementById\(\&quot;(?<id>rangeOutput\d*)\&quot;\)\.innerHTML=this\.value">' .
            "\n" . '<span id="(?P=id)">10</span>~',
            $tag->render()
        );
    }

    public function testEmptyOutputTag(): void
    {
        $tag = Range::tag();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The output tag name it cannot be empty value.');
        $tag->outputTag('');
    }

    public function testImmutability(): void
    {
        $tag = Range::tag();

        $this->assertNotSame($tag, $tag->min(null));
        $this->assertNotSame($tag, $tag->max(null));
        $this->assertNotSame($tag, $tag->step(null));
        $this->assertNotSame($tag, $tag->list(null));
        $this->assertNotSame($tag, $tag->showOutput());
        $this->assertNotSame($tag, $tag->outputTag('b'));
        $this->assertNotSame($tag, $tag->addOutputAttributes([]));
        $this->assertNotSame($tag, $tag->outputAttributes([]));
    }
}
