<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mi;
use Yiisoft\Html\Tag\MathML\Mmultiscripts;
use Yiisoft\Html\Tag\MathML\Mn;
use Yiisoft\Html\Tag\MathML\Mprescripts;

final class MmultiscriptsTest extends TestCase
{
    public function testSimple(): void
    {
        $mmultiscripts = Mmultiscripts::tag()
            ->base(Mi::tag()->identifier('X'))
            ->post(
                Mi::tag()->identifier('a'),
                Mi::tag()->identifier('b'),
            )
            ->pre(
                Mi::tag()->identifier('c'),
                Mi::tag()->identifier('d'),
            );

        $this->assertSame(
            '<mmultiscripts>' . "\n" .
            '<mi>X</mi>' . "\n" .
            '<mi>a</mi>' . "\n" .
            '<mi>b</mi>' . "\n" .
            '<mprescripts>' . "\n" .
            '<mi>c</mi>' . "\n" .
            '<mi>d</mi>' . "\n" .
            '</mmultiscripts>',
            (string) $mmultiscripts
        );
    }

    public function testPost(): void
    {
        $mmultiscripts = Mmultiscripts::tag()
            ->base(Mi::tag()->identifier('X'))
            ->post(
                Mi::tag()->identifier('a'),
            );

        $this->assertSame(
            '<mmultiscripts>' . "\n" .
            '<mi>X</mi>' . "\n" .
            '<mi>a</mi>' . "\n" .
            '</mmultiscripts>',
            (string) $mmultiscripts
        );
    }

    public function testWithoutPre(): void
    {
        $mmultiscripts = Mmultiscripts::tag()
            ->base(Mi::tag()->identifier('X'))
            ->post(
                Mi::tag()->identifier('a'),
                Mi::tag()->identifier('b'),
            );

        $this->assertSame(
            '<mmultiscripts>' . "\n" .
            '<mi>X</mi>' . "\n" .
            '<mi>a</mi>' . "\n" .
            '<mi>b</mi>' . "\n" .
            '</mmultiscripts>',
            (string) $mmultiscripts
        );
    }

    public function testCustomMprescripts(): void
    {
        $mmultiscripts = Mmultiscripts::tag()
            ->base(Mi::tag()->identifier('X'))
            ->mprescripts(Mprescripts::tag()->id('test-id'))
            ->post(
                Mn::tag()->value(1),
                Mn::tag()->value(2),
                Mn::tag()->value(3),
                Mn::tag()->value(4),
            )
            ->pre(
                Mn::tag()->value(5),
                Mn::tag()->value(6),
                Mn::tag()->value(7),
                Mn::tag()->value(8),
            );

        $this->assertSame(
            '<mmultiscripts>' . "\n" .
            '<mi>X</mi>' . "\n" .
            '<mn>1</mn>' . "\n" .
            '<mn>2</mn>' . "\n" .
            '<mn>3</mn>' . "\n" .
            '<mn>4</mn>' . "\n" .
            '<mprescripts id="test-id">' . "\n" .
            '<mn>5</mn>' . "\n" .
            '<mn>6</mn>' . "\n" .
            '<mn>7</mn>' . "\n" .
            '<mn>8</mn>' . "\n" .
            '</mmultiscripts>',
            (string) $mmultiscripts
        );
    }
}
