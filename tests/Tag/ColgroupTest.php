<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use Yiisoft\Html\Tag\Col;
use Yiisoft\Html\Tag\Colgroup;
use PHPUnit\Framework\TestCase;

final class ColgroupTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<colgroup>' . "\n"
            . '<col>' . "\n"
            . '<col span="2" class="red">' . "\n"
            . '<col span="2" class="blue">' . "\n"
            . '</colgroup>',
            (new Colgroup())
                ->columns(
                    new Col(),
                    (new Col())
                        ->span(2)
                        ->class('red'),
                    (new Col())
                        ->span(2)
                        ->class('blue'),
                )
                ->render(),
        );
    }

    public function testColumns(): void
    {
        $tag = (new Colgroup())->columns(
            new Col(),
            (new Col())->span(2),
        );

        $this->assertSame(
            '<colgroup>' . "\n"
            . '<col>' . "\n"
            . '<col span="2">' . "\n"
            . '</colgroup>',
            $tag->render(),
        );
    }

    public function testAddColumns(): void
    {
        $tag = (new Colgroup())
            ->columns(
                new Col(),
                (new Col())->span(2),
            )
            ->addColumns(
                (new Col())->span(3),
                (new Col())->span(4),
            );

        $this->assertSame(
            '<colgroup>' . "\n"
            . '<col>' . "\n"
            . '<col span="2">' . "\n"
            . '<col span="3">' . "\n"
            . '<col span="4">' . "\n"
            . '</colgroup>',
            $tag->render(),
        );
    }

    public static function dataSpan(): array
    {
        return [
            ['<colgroup></colgroup>', null],
            ['<colgroup span="2"></colgroup>', 2],
        ];
    }

    #[DataProvider('dataSpan')]
    public function testSpan(string $expected, ?int $span): void
    {
        $this->assertSame($expected, (new Colgroup())
            ->span($span)
            ->render());
    }

    public function testImmutability(): void
    {
        $tag = new Colgroup();
        $this->assertNotSame($tag, $tag->columns());
        $this->assertNotSame($tag, $tag->addColumns());
        $this->assertNotSame($tag, $tag->span(null));
    }
}
