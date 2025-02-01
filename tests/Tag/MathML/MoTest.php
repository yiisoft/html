<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Stringable;
use Yiisoft\Html\Tag\MathML\Mo;
use Yiisoft\Html\Tag\MathML\OperatorForm;

use function array_map;

final class MoTest extends TestCase
{
    public static function operatorDataProvider(): array
    {
        return [
            ['['],
            [';'],
            [')'],
            [
                new class () {
                    public function __toString()
                    {
                        return '=';
                    }
                }
            ]
        ];
    }

    /**
     * @dataProvider operatorDataProvider
     */
    public function testOperator(string|Stringable $operator): void
    {
        $mo = Mo::tag()->operator($operator);

        $this->assertSame('<mo>' . $operator . '</mo>', (string) $mo);
    }

    public static function formDataProvider(): array
    {
        return [
            ...array_map(static fn (OperatorForm $case) => [$case], OperatorForm::cases()),
            ...[
                [null]
            ],
        ];
    }

    /**
     * @dataProvider formDataProvider
     */
    public function testForm(OperatorForm|null $form): void
    {
        $mo = Mo::tag()
            ->form($form)
            ->operator('+');

        if ($form) {
            $this->assertSame('<mo form="' . $form->name . '">+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        }
    }

    public static function booleanDataProvider(): array
    {
        return [
            [true],
            [false],
            [null],
        ];
    }

    public static function lengthDataProvider(): array
    {
        return [
            ['10px'],
            ['20%'],
            ['0'],
            [null]
        ];
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testFence(bool|null $fence): void
    {
        $mo = Mo::tag()
            ->fence($fence)
            ->operator('+');

        if ($fence === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo fence="' . ($fence ? 'true' : 'false') . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testLargeop(bool|null $largeop): void
    {
        $mo = Mo::tag()
            ->largeop($largeop)
            ->operator('+');

        if ($largeop === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo largeop="' . ($largeop ? 'true' : 'false') . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testLspace(string|null $lspace): void
    {
        $mo = Mo::tag()
            ->lspace($lspace)
            ->operator('+');

        if ($lspace === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo lspace="' . $lspace . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testMaxSize(string|null $maxsize): void
    {
        $mo = Mo::tag()
            ->maxsize($maxsize)
            ->operator('+');

        if ($maxsize === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo maxsize="' . $maxsize . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testMinSize(string|null $minsize): void
    {
        $mo = Mo::tag()
            ->minsize($minsize)
            ->operator('+');

        if ($minsize === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo minsize="' . $minsize . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testMovablelimits(bool|null $movablelimits): void
    {
        $mo = Mo::tag()
            ->movablelimits($movablelimits)
            ->operator('+');

        if ($movablelimits === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo movablelimits="' . ($movablelimits ? 'true' : 'false') . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider lengthDataProvider
     */
    public function testRspace(string|null $rspace): void
    {
        $mo = Mo::tag()
            ->rspace($rspace)
            ->operator('+');

        if ($rspace === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo rspace="' . $rspace . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testSeparator(bool|null $separator): void
    {
        $mo = Mo::tag()
            ->separator($separator)
            ->operator('+');

        if ($separator === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo separator="' . ($separator ? 'true' : 'false') . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testStretchy(bool|null $stretchy): void
    {
        $mo = Mo::tag()
            ->stretchy($stretchy)
            ->operator('+');

        if ($stretchy === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo stretchy="' . ($stretchy ? 'true' : 'false') . '">+</mo>', (string) $mo);
        }
    }

    /**
     * @dataProvider booleanDataProvider
     */
    public function testSymmetric(bool|null $symmetric): void
    {
        $mo = Mo::tag()
            ->symmetric($symmetric)
            ->operator('+');

        if ($symmetric === null) {
            $this->assertSame('<mo>+</mo>', (string) $mo);
        } else {
            $this->assertSame('<mo symmetric="' . ($symmetric ? 'true' : 'false') . '">+</mo>', (string) $mo);
        }
    }

    public function testImmutable(): void
    {
        $mo = Mo::tag();

        $this->assertNotSame($mo, $mo->operator('+'));
        $this->assertNotSame($mo, $mo->form(null));
        $this->assertNotSame($mo, $mo->fence(true));
        $this->assertNotSame($mo, $mo->largeop(true));
        $this->assertNotSame($mo, $mo->lspace('5px'));
        $this->assertNotSame($mo, $mo->maxsize('5px'));
        $this->assertNotSame($mo, $mo->minsize('5px'));
        $this->assertNotSame($mo, $mo->movablelimits(false));
        $this->assertNotSame($mo, $mo->rspace('5px'));
        $this->assertNotSame($mo, $mo->separator(false));
        $this->assertNotSame($mo, $mo->stretchy(null));
        $this->assertNotSame($mo, $mo->symmetric(true));
    }
}
