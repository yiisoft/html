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
}
