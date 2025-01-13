<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Html\Tag\Col;
use PHPUnit\Framework\TestCase;

final class ColTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<col span="2" style="background-color:#f00;">',
            Col::tag()
                ->span(2)
                ->attribute('style', 'background-color:#f00;')
                ->render()
        );
    }

    public static function dataSpan(): array
    {
        return [
            ['<col>', null],
            ['<col span="2">', 2],
        ];
    }

    #[DataProvider('dataSpan')]
    public function testSpan(string $expected, ?int $span): void
    {
        $this->assertSame(
            $expected,
            Col::tag()->span($span)->render()
        );
    }

    public function testImmutability(): void
    {
        $tag = Col::tag();
        $this->assertNotSame($tag, $tag->span(null));
    }
}
