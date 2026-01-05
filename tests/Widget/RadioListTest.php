<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Widget;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tests\Support\IntegerEnum;
use Yiisoft\Html\Tests\Support\StringEnum;
use Yiisoft\Html\Widget\RadioList\RadioItem;
use Yiisoft\Html\Widget\RadioList\RadioList;

final class RadioListTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="0">' . "\n"
            . '<div id="main">' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" checked type="radio"> Two</label>' . "\n"
            . '<label><input name="test" value="5" type="radio"> Five</label>' . "\n"
            . '</div>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two', 5 => 'Five'])
                ->uncheckValue(0)
                ->value(2)
                ->containerAttributes(['id' => 'main'])
                ->render(),
        );
    }

    public function testName(): void
    {
        $widget = RadioList::create('a')
            ->items([1 => 'One'])
            ->name('b');

        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="b" value="1" type="radio"> One</label>' . "\n"
            . '</div>',
            $widget->render(),
        );
    }

    public function testWithoutContainer(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" type="radio"> One</label>',
            RadioList::create('test')
                ->items([1 => 'One'])
                ->withoutContainer()
                ->render(),
        );
    }

    public static function dataContainerTag(): array
    {
        return [
            [
                '<label><input name="test" value="1" type="radio"> One</label>',
                null,
            ],
            [
                '<label><input name="test" value="1" type="radio"> One</label>',
                '',
            ],
            [
                '<section>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '</section>',
                'section',
            ],
        ];
    }

    #[DataProvider('dataContainerTag')]
    public function testContainerTag(string $expected, ?string $name): void
    {
        $this->assertSame(
            $expected,
            RadioList::create('test')
                ->items([1 => 'One'])
                ->containerTag($name)
                ->render(),
        );
    }

    public function testContainerAttributes(): void
    {
        $this->assertSame(
            '<div id="main">' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '</div>',
            RadioList::create('test')
                ->items([1 => 'One'])
                ->containerAttributes(['id' => 'main'])
                ->render(),
        );
    }

    public function testRadioAttributes(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" class="red" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" class="red" type="radio"> Two</label>',
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
        $this->assertSame(
            '<label><input name="test" value="1" readonly class="red" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" readonly class="red" type="radio"> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->readonly()
                ->addRadioAttributes(['class' => 'red'])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testReplaceRadioAttributes(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" class="red" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" class="red" type="radio"> Two</label>',
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

    public function testRadioLabelAttributes(): void
    {
        $this->assertSame(
            '<label class="red"><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label class="red"><input name="test" value="2" type="radio"> Two</label>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two'])
                ->radioLabelAttributes(['class' => 'red'])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testRadioLabelAttributesMerge(): void
    {
        $this->assertSame(
            '<label class="red" data-type="label"><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label class="red" data-type="label"><input name="test" value="2" type="radio"> Two</label>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two'])
                ->radioLabelAttributes(['class' => 'red'])
                ->addRadioLabelAttributes(['data-type' => 'label'])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testIndividualInputAttributes(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" class="red" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" class="blue" type="radio"> Two</label>' . "\n"
            . '<label><input name="test" value="3" class="green" type="radio"> Three</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                ])
                ->radioAttributes(['class' => 'red'])
                ->individualInputAttributes([
                    2 => ['class' => 'blue'],
                    3 => ['class' => 'green'],
                ])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testIndividualUncheckInputAttributes(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="0" class="blue">' . "\n"
            . '<label><input name="test" value="1" class="red" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" class="red" type="radio"> Two</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->uncheckValue(0)
                ->radioAttributes(['class' => 'red'])
                ->individualInputAttributes([
                    0 => ['class' => 'blue'],
                ])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testIndividualInputAttributesMerge(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" class="yellow" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" class="cyan" type="radio"> Two</label>' . "\n"
            . '<label><input name="test" value="3" class="green" type="radio"> Three</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                ])
                ->radioAttributes(['class' => 'red'])
                ->addIndividualInputAttributes([
                    2 => ['class' => 'blue'],
                    3 => ['class' => 'green'],
                ])
                ->addIndividualInputAttributes([
                    1 => ['class' => 'yellow'],
                    2 => ['class' => 'cyan'],
                ])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testIndividualInputAttributesReplace(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" class="yellow" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" class="red" type="radio"> Two</label>' . "\n"
            . '<label><input name="test" value="3" class="red" type="radio"> Three</label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                    3 => 'Three',
                ])
                ->radioAttributes(['class' => 'red'])
                ->addIndividualInputAttributes([
                    2 => ['class' => 'blue'],
                    3 => ['class' => 'green'],
                ])
                ->individualInputAttributes([
                    1 => ['class' => 'yellow'],
                ])
                ->withoutContainer()
                ->render(),
        );
    }

    public function testItems(): void
    {
        $this->assertSame(
            '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" type="radio"> &lt;b&gt;Two&lt;/b&gt;</label>',
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
        $this->assertSame(
            '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" type="radio"> <b>Two</b></label>',
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => '<b>Two</b>',
                ], false)
                ->withoutContainer()
                ->render(),
        );
    }

    public static function dataItemsFromValues(): array
    {
        return [
            [
                '<label><input name="test" value="1" type="radio"> 1</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> 2</label>',
                [1, 2],
            ],
            [
                '<label><input name="test" value="One" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="&lt;b&gt;Two&lt;/b&gt;" type="radio"> &lt;b&gt;Two&lt;/b&gt;</label>',
                ['One', '<b>Two</b>'],
            ],
            [
                '<label><input name="test" value="1" type="radio"> 1</label>' . "\n"
                . '<label><input name="test" value type="radio"></label>',
                [true, false],
            ],
        ];
    }

    #[DataProvider('dataItemsFromValues')]
    public function testItemsFromValues(string $expected, array $values): void
    {
        $this->assertSame(
            $expected,
            RadioList::create('test')
                ->itemsFromValues($values)
                ->withoutContainer()
                ->render(),
        );
    }

    public function testItemsFromValuesWithoutEncodeLabel(): void
    {
        $this->assertSame(
            '<label><input name="test" value="One" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="&lt;b&gt;Two&lt;/b&gt;" type="radio"> <b>Two</b></label>',
            RadioList::create('test')
                ->itemsFromValues([
                    'One',
                    '<b>Two</b>',
                ], false)
                ->withoutContainer()
                ->render(),
        );
    }

    public static function dataValue(): array
    {
        return [
            ["<div>\n</div>", [], null],
            ["<div>\n</div>", [], 42],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                [1 => 'One', 2 => 'Two'],
                null,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                [1 => 'One', 2 => 'Two'],
                7,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" checked type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                [1 => 'One', 2 => 'Two'],
                1,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" checked type="radio"> Two</label>' . "\n"
                . '</div>',
                [1 => 'One', 2 => 'Two'],
                2,
            ],
            ["<div>\n</div>", [], StringEnum::A],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="one" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="two" type="radio"> Two</label>' . "\n"
                . '</div>',
                [StringEnum::A->value => 'One', StringEnum::B->value => 'Two'],
                StringEnum::C,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="one" checked type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="two" type="radio"> Two</label>' . "\n"
                . '</div>',
                [StringEnum::A->value => 'One', StringEnum::B->value => 'Two'],
                StringEnum::A,
            ],
            ["<div>\n</div>", [], IntegerEnum::A],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two'],
                IntegerEnum::C,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" checked type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                [IntegerEnum::A->value => 'One', IntegerEnum::B->value => 'Two'],
                IntegerEnum::A,
            ],
        ];
    }

    #[DataProvider('dataValue')]
    public function testValue(string $expected, array $items, $value): void
    {
        $this->assertSame(
            $expected,
            RadioList::create('test')
                ->items($items)
                ->value($value)
                ->render(),
        );
    }

    public static function dataForm(): array
    {
        return [
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                null,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" form type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" form type="radio"> Two</label>' . "\n"
                . '</div>',
                '',
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" form="post" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" form="post" type="radio"> Two</label>' . "\n"
                . '</div>',
                'post',
            ],
        ];
    }

    #[DataProvider('dataForm')]
    public function testForm(string $expected, ?string $formId): void
    {
        $this->assertSame(
            $expected,
            RadioList::create('test')
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->form($formId)
                ->render(),
        );
    }

    public function testReadonly(): void
    {
        $checkbox = RadioList::create('test')
            ->items([
                1 => 'One',
                2 => 'Two',
            ]);

        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" readonly type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" readonly type="radio"> Two</label>' . "\n"
            . '</div>',
            $checkbox
                ->readonly()
                ->render(),
        );

        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
            . '</div>',
            $checkbox
                ->readonly(false)
                ->render(),
        );
        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
            . '</div>',
            $checkbox
                ->readonly(true)
                ->readonly(false)
                ->render(),
        );
    }

    public function testDisabled(): void
    {
        $checkbox = RadioList::create('test')
            ->items([
                1 => 'One',
                2 => 'Two',
            ]);

        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" disabled type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" disabled type="radio"> Two</label>' . "\n"
            . '</div>',
            $checkbox
                ->disabled()
                ->render(),
        );

        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
            . '</div>',
            $checkbox
                ->disabled(false)
                ->render(),
        );
        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
            . '</div>',
            $checkbox
                ->disabled(true)
                ->disabled(false)
                ->render(),
        );
    }

    public static function dataUncheckValue(): array
    {
        return [
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                'test',
                null,
            ],
            [
                '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                'test',
                null,
            ],
            [
                '<input type="hidden" name="test" value="7">' . "\n"
                . '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                'test',
                7,
            ],
            [
                '<input type="hidden" name="test" value="7">' . "\n"
                . '<div>' . "\n"
                . '<label><input name="test" value="1" type="radio"> One</label>' . "\n"
                . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
                . '</div>',
                'test',
                7,
            ],
        ];
    }

    #[DataProvider('dataUncheckValue')]
    public function testUncheckValue(string $expected, string $name, $value): void
    {
        $this->assertSame(
            $expected,
            RadioList::create($name)
                ->items([
                    1 => 'One',
                    2 => 'Two',
                ])
                ->uncheckValue($value)
                ->render(),
        );
    }

    public function testUncheckValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="test" value="7" disabled>' . "\n"
            . '<label><input name="test" value="1" disabled type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" disabled type="radio"> Two</label>',
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
        $this->assertSame(
            '<input type="hidden" name="test" value="7" form="post">' . "\n"
            . '<label><input name="test" value="1" form="post" type="radio"> One</label>' . "\n"
            . '<label><input name="test" value="2" form="post" type="radio"> Two</label>',
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
        $this->assertSame(
            '<div>' . "\n"
            . '<label><input name="test" value="1" type="radio"> One</label><br>'
            . '<label><input name="test" value="2" type="radio"> Two</label>' . "\n"
            . '</div>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two'])
                ->separator('<br>')
                ->render(),
        );
    }

    public function testItemFormatter(): void
    {
        $this->assertSame(
            '<div>' . "\n"
            . '<div>0) <label><input name="test" value="1" type="radio"> One</label></div>'
            . '<div>1) <label><input name="test" value="2" type="radio"> Two</label></div>' . "\n"
            . '</div>',
            RadioList::create('test')
                ->items([1 => 'One', 2 => 'Two'])
                ->itemFormatter(fn(RadioItem $item): string => '<div>'
                    . $item->index . ') '
                    . Html::radio(
                        $item->radioAttributes['name'],
                        $item->radioAttributes['value'],
                        $item->radioAttributes,
                    )
                        ->checked($item->checked)
                        ->label($item->label)
                    . '</div>')
                ->separator('')
                ->render(),
        );
    }

    public function testDisableRadioLabelWrap(): void
    {
        $html = RadioList::create('test')
            ->items([1 => 'One', 2 => 'Two'])
            ->addIndividualInputAttributes([
                1 => ['id' => 'id1'],
                2 => ['id' => 'id2'],
            ])
            ->radioLabelWrap(false)
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <input name="test" value="1" id="id1" type="radio"> <label for="id1">One</label>
            <input name="test" value="2" id="id2" type="radio"> <label for="id2">Two</label>
            </div>
            HTML,
            $html,
        );
    }

    public function testRadioWrap(): void
    {
        $html = RadioList::create('test')
            ->items([1 => 'One', 2 => 'Two'])
            ->radioWrapTag('div')
            ->radioWrapAttributes(['class' => 'form-check'])
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <div class="form-check">
            <label><input name="test" value="1" type="radio"> One</label>
            </div>
            <div class="form-check">
            <label><input name="test" value="2" type="radio"> Two</label>
            </div>
            </div>
            HTML,
            $html,
        );
    }

    public static function dataRadioWrapClass(): array
    {
        return [
            ['', []],
            ['', [null]],
            [' class', ['']],
            [' class="main"', ['main']],
            [' class="main bold"', ['main bold']],
            [' class="main bold"', ['main', 'bold']],
            [' class="main bold"', [null, 'main', null, 'bold', null]],
        ];
    }

    #[DataProvider('dataRadioWrapClass')]
    public function testRadioWrapClass(string $expected, array $class): void
    {
        $html = RadioList::create('test')
            ->items([1 => 'One', 2 => 'Two'])
            ->radioWrapTag('div')
            ->radioWrapAttributes(['class' => 'form-check'])
            ->radioWrapClass(...$class)
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <div$expected>
            <label><input name="test" value="1" type="radio"> One</label>
            </div>
            <div$expected>
            <label><input name="test" value="2" type="radio"> Two</label>
            </div>
            </div>
            HTML,
            $html,
        );
    }

    public static function dataAddRadioWrapClass(): array
    {
        return [
            [' class="form-check"', []],
            [' class="form-check"', [null]],
            [' class="form-check main"', ['main']],
            [' class="form-check main bold"', ['main bold']],
            [' class="form-check main bold"', ['main', 'bold']],
            [' class="form-check main bold"', [null, 'main', null, 'bold', null]],
        ];
    }

    #[DataProvider('dataAddRadioWrapClass')]
    public function testAddRadioWrapClass(string $expected, array $class): void
    {
        $html = RadioList::create('test')
            ->items([1 => 'One', 2 => 'Two'])
            ->radioWrapTag('div')
            ->radioWrapAttributes(['class' => 'form-check'])
            ->addRadioWrapClass(...$class)
            ->render();

        $this->assertSame(
            <<<HTML
            <div>
            <div$expected>
            <label><input name="test" value="1" type="radio"> One</label>
            </div>
            <div$expected>
            <label><input name="test" value="2" type="radio"> Two</label>
            </div>
            </div>
            HTML,
            $html,
        );
    }

    public function testStringable(): void
    {
        $this->assertSame(
            "<div>\n</div>",
            (string) RadioList::create('test'),
        );
    }

    public function testImmutability(): void
    {
        $widget = RadioList::create('test');
        $this->assertNotSame($widget, $widget->name('test'));
        $this->assertNotSame($widget, $widget->withoutContainer());
        $this->assertNotSame($widget, $widget->containerTag(''));
        $this->assertNotSame($widget, $widget->containerAttributes([]));
        $this->assertNotSame($widget, $widget->radioWrapTag('div'));
        $this->assertNotSame($widget, $widget->radioWrapAttributes([]));
        $this->assertNotSame($widget, $widget->radioWrapClass());
        $this->assertNotSame($widget, $widget->addRadioWrapClass());
        $this->assertNotSame($widget, $widget->addRadioAttributes([]));
        $this->assertNotSame($widget, $widget->radioAttributes([]));
        $this->assertNotSame($widget, $widget->addRadioLabelAttributes([]));
        $this->assertNotSame($widget, $widget->radioLabelAttributes([]));
        $this->assertNotSame($widget, $widget->radioLabelWrap(false));
        $this->assertNotSame($widget, $widget->addIndividualInputAttributes([]));
        $this->assertNotSame($widget, $widget->individualInputAttributes([]));
        $this->assertNotSame($widget, $widget->items([]));
        $this->assertNotSame($widget, $widget->itemsFromValues([]));
        $this->assertNotSame($widget, $widget->value(null));
        $this->assertNotSame($widget, $widget->form(''));
        $this->assertNotSame($widget, $widget->readonly());
        $this->assertNotSame($widget, $widget->disabled());
        $this->assertNotSame($widget, $widget->uncheckValue(null));
        $this->assertNotSame($widget, $widget->separator(''));
        $this->assertNotSame($widget, $widget->itemFormatter(null));
    }
}
