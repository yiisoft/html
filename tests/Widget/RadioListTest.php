<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Widget;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList;

final class RadioListTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="0">' . "\n" .
            '<div id="main">' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2" checked> Two</label>' . "\n" .
            '<label><input type="radio" name="test" value="5"> Five</label>' . "\n" .
            '</div>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two', 5 => 'Five'])
                ->uncheckValue(0)
                ->value(2)
                ->containerAttributes(['id' => 'main'])
                ->render(),
        );
    }

    public function testWithoutContainer(): void
    {
        self::assertSame(
            '<label><input type="radio" name="test" value="1"> One</label>',
            RadioList::create('test')->items([1 => 'One'])->withoutContainer()->render(),
        );
    }

    public function dataContainerTag(): array
    {
        return [
            [
                '<label><input type="radio" name="test" value="1"> One</label>',
                null,
            ],
            [
                '<label><input type="radio" name="test" value="1"> One</label>',
                '',
            ],
            [
                '<section>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '</section>',
                'section',
            ],
        ];
    }

    /**
     * @dataProvider dataContainerTag
     */
    public function testContainerTag(string $expected, ?string $name): void
    {
        self::assertSame(
            $expected,
            RadioList::create('test')->items([1 => 'One'])->containerTag($name)->render(),
        );
    }

    public function testContainerAttributes(): void
    {
        self::assertSame(
            '<div id="main">' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '</div>',
            RadioList::create('test')->items([1 => 'One'])->containerAttributes(['id' => 'main'])->render(),
        );
    }

    public function testRadioAttributes(): void
    {
        self::assertSame(
            '<label><input type="radio" class="red" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" class="red" name="test" value="2"> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->radioAttributes(['class' => 'red'])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testRadioAttributesMerge(): void
    {
        self::assertSame(
            '<label><input type="radio" class="red" name="test" value="1" readonly> One</label>' . "\n" .
            '<label><input type="radio" class="red" name="test" value="2" readonly> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->readonly()
                ->radioAttributes(['class' => 'red'])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testReplaceRadioAttributes(): void
    {
        self::assertSame(
            '<label><input type="radio" class="red" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" class="red" name="test" value="2"> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->readonly()
                ->replaceRadioAttributes(['class' => 'red'])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testItems(): void
    {
        self::assertSame(
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2"> &lt;b&gt;Two&lt;/b&gt;</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => '<b>Two</b>',
                ])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testItemsWithoutEncodeLabel(): void
    {
        self::assertSame(
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2"> <b>Two</b></label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => '<b>Two</b>',
                ], false)
                ->withoutContainer()
                ->render(),
        );
    }

    public function dataValue(): array
    {
        return [
            ["<div>\n</div>", [], null],
            ["<div>\n</div>", [], 42],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                [1 => 'One', 2 => 'Two'],
                null,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                [1 => 'One', 2 => 'Two'],
                7,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1" checked> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                [1 => 'One', 2 => 'Two'],
                1,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2" checked> Two</label>' . "\n" .
                '</div>',
                [1 => 'One', 2 => 'Two'],
                2,
            ],
        ];
    }

    /**
     * @dataProvider dataValue
     *
     * @psalm-param array<array-key, string> $items
     * @psalm-param \Stringable|scalar|null $value
     */
    public function testValue(string $expected, array $items, $value): void
    {
        self::assertSame(
            $expected,
            RadioList::create('test')->items($items)->value($value)->render(),
        );
    }

    public function dataForm(): array
    {
        return [
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                null,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1" form=""> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2" form=""> Two</label>' . "\n" .
                '</div>',
                '',
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1" form="post"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2" form="post"> Two</label>' . "\n" .
                '</div>',
                'post',
            ],
        ];
    }

    /**
     * @dataProvider dataForm
     */
    public function testForm(string $expected, ?string $formId): void
    {
        self::assertSame(
            $expected,
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->form($formId)
                ->render()
        );
    }

    public function testReadonly(): void
    {
        $checkbox = RadioList::create('test')
            ->items([
                1 => 'One',
                2 => 'Two',
            ]);

        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1" readonly> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2" readonly> Two</label>' . "\n" .
            '</div>',
            $checkbox->readonly()->render()
        );

        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
            '</div>',
            $checkbox->readonly(false)->render()
        );
        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
            '</div>',
            $checkbox->readonly(true)->readonly(false)->render()
        );
    }

    public function testDisabled(): void
    {
        $checkbox = RadioList::create('test')
            ->items([
                1 => 'One',
                2 => 'Two',
            ]);

        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1" disabled> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2" disabled> Two</label>' . "\n" .
            '</div>',
            $checkbox->disabled()->render()
        );

        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
            '</div>',
            $checkbox->disabled(false)->render()
        );
        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
            '</div>',
            $checkbox->disabled(true)->disabled(false)->render()
        );
    }

    public function dataUncheckValue(): array
    {
        return [
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                'test',
                null,
            ],
            [
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                'test',
                null,
            ],
            [
                '<input type="hidden" name="test" value="7">' . "\n" .
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                'test',
                7,
            ],
            [
                '<input type="hidden" name="test" value="7">' . "\n" .
                '<div>' . "\n" .
                '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
                '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
                '</div>',
                'test',
                7,
            ],
        ];
    }

    /**
     * @dataProvider dataUncheckValue
     *
     * @psalm-param \Stringable|scalar|null $value
     */
    public function testUncheckValue(string $expected, string $name, $value): void
    {
        self::assertSame(
            $expected,
            RadioList::create($name)
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->uncheckValue($value)
                ->render()
        );
    }

    public function testUncheckValueDisabled(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="7" disabled>' . "\n" .
            '<label><input type="radio" name="test" value="1" disabled> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2" disabled> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->uncheckValue(7)
                ->disabled()
                ->withoutContainer()
                ->render(),
        );
    }

    public function testUncheckValueForm(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="7" form="post">' . "\n" .
            '<label><input type="radio" name="test" value="1" form="post"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2" form="post"> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->uncheckValue(7)
                ->form('post')
                ->withoutContainer()
                ->render(),
        );
    }

    public function testSeparator(): void
    {
        self::assertSame(
            '<div>' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label><br>' .
            '<label><input type="radio" name="test" value="2"> Two</label>' . "\n" .
            '</div>',
            RadioList::create('test')->items([1 => 'One', 2 => 'Two'])->separator('<br>')->render(),
        );
    }

    public function testItemFormatter(): void
    {
        self::assertSame(
            '<div>' . "\n" .
            '<div>0) <label><input type="radio" name="test" value="1"> One</label></div>' .
            '<div>1) <label><input type="radio" name="test" value="2"> Two</label></div>' . "\n" .
            '</div>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two'])
                ->itemFormatter(function (RadioItem $item): string {
                    return '<div>' .
                        $item->index . ') ' .
                        Html::radio($item->radioAttributes['name'], $item->radioAttributes['value'])
                            ->attributes($item->radioAttributes)
                            ->checked($item->checked)
                            ->label($item->label) .
                        '</div>';
                })
                ->separator('')
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $widget = RadioList::create('test');
        self::assertNotSame($widget, $widget->withoutContainer());
        self::assertNotSame($widget, $widget->containerTag(''));
        self::assertNotSame($widget, $widget->containerAttributes([]));
        self::assertNotSame($widget, $widget->radioAttributes([]));
        self::assertNotSame($widget, $widget->replaceRadioAttributes([]));
        self::assertNotSame($widget, $widget->items([]));
        self::assertNotSame($widget, $widget->value(null));
        self::assertNotSame($widget, $widget->form(''));
        self::assertNotSame($widget, $widget->readonly());
        self::assertNotSame($widget, $widget->disabled());
        self::assertNotSame($widget, $widget->uncheckValue(null));
        self::assertNotSame($widget, $widget->separator(''));
        self::assertNotSame($widget, $widget->itemFormatter(null));
    }
}
