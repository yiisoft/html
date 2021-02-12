<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use ArrayObject;
use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tests\Objects\IterableObject;

final class HtmlTest extends TestCase
{
    /**
     * Use different values in different tests
     *
     * @var mixed
     */
    public static $hrtimeResult;

    protected function setUp(): void
    {
        self::$hrtimeResult = null;
        parent::setUp();
    }

    public function testGenerateId(): void
    {
        $this->assertMatchesRegularExpression('/i\d+/', Html::generateId());
        $this->assertMatchesRegularExpression('/test\d+/', Html::generateId('test'));

        self::$hrtimeResult = 123;
        $this->assertSame('i1231', Html::generateId());
        $this->assertSame('i1232', Html::generateId());
        self::$hrtimeResult = 124;
        $this->assertSame('i1241', Html::generateId());
    }

    public function dataEscapeJavaScriptStringValue(): array
    {
        return [
            ['</script>', '<\/script>'],
            ['"double" quotes', '\"double\" quotes'],
            ["'single' quotes", "\'single\' quotes"],
            ['slashes //\\', 'slashes \/\/\\\\'],
            [36.6, '36.6'],
        ];
    }

    /**
     * @dataProvider dataEscapeJavaScriptStringValue
     *
     * @param mixed $value
     * @param string $expected
     */
    public function testEscapeJavaScriptStringValue($value, string $expected): void
    {
        $this->assertSame($expected, Html::escapeJavaScriptStringValue($value));
    }

    public function testTag(): void
    {
        $this->assertSame('<br>', Html::tag('br'));
        $this->assertSame('<BR>', Html::tag('BR'));
        $this->assertSame('<span></span>', Html::tag('span'));
        $this->assertSame('<div>content</div>', Html::tag('div', 'content'));
        $this->assertSame(
            '<input type="text" name="test" value="&lt;&gt;">',
            Html::tag('input', '', ['type' => 'text', 'name' => 'test', 'value' => '<>'])
        );
        $this->assertSame('<span disabled></span>', Html::tag('span', '', ['disabled' => true]));
        $this->assertSame('test', Html::tag(false, 'test'));
        $this->assertSame('test', Html::tag(null, 'test'));
    }

    public function testBeginTag(): void
    {
        $this->assertSame('<br>', Html::beginTag('br'));
        $this->assertSame(
            '<span id="test" class="title">',
            Html::beginTag('span', ['id' => 'test', 'class' => 'title'])
        );
        $this->assertSame('', Html::beginTag(null));
        $this->assertSame('', Html::beginTag(false));
    }

    public function testEndTag(): void
    {
        $this->assertSame('</br>', Html::endTag('br'));
        $this->assertSame('</span>', Html::endTag('span'));
        $this->assertSame('', Html::endTag(null));
        $this->assertSame('', Html::endTag(false));
    }

    public function testStyle(): void
    {
        $this->assertSame('<style></style>', Html::style()->render());
        $this->assertSame('<style>.red{color:#f00}</style>', Html::style('.red{color:#f00}')->render());
    }

    public function testScript(): void
    {
        $this->assertSame('<script></script>', Html::script()->render());
        $this->assertSame('<script>alert(15)</script>', Html::script('alert(15)')->render());
    }

    public function testLink(): void
    {
        self::assertSame('<link>', Html::link()->render());
        self::assertSame('<link href="">', Html::link('')->render());
        self::assertSame('<link href="main.css">', Html::link('main.css')->render());
    }

    public function testCssFile(): void
    {
        self::assertSame(
            '<link href="http://example.com" rel="stylesheet">',
            Html::cssFile('http://example.com')->render()
        );
        self::assertSame(
            '<link href="" rel="stylesheet">',
            Html::cssFile('')->render()
        );
    }

    public function testJavaScriptFile(): void
    {
        self::assertSame(
            '<script src="http://example.com"></script>',
            Html::javaScriptFile('http://example.com')->render()
        );
        self::assertSame(
            '<script src=""></script>',
            Html::javaScriptFile('')->render()
        );
    }

    public function testA(): void
    {
        $this->assertSame('<a href="#">link</a>', Html::a()->url('#')->content('link')->render());
    }

    public function testImg(): void
    {
        $this->assertSame('<img>', Html::img()->render());
        $this->assertSame('<img src="">', Html::img('')->render());
        $this->assertSame('<img src="face.png">', Html::img('face.png')->render());
    }

    public function testLabel(): void
    {
        $this->assertSame('<label></label>', Html::label()->render());
        $this->assertSame('<label>Name</label>', Html::label('Name')->render());
        $this->assertSame('<label for="">Name</label>', Html::label('Name', '')->render());
        $this->assertSame('<label for="fieldName">Name</label>', Html::label('Name', 'fieldName')->render());
    }

    public function testButton(): void
    {
        $this->assertSame(
            '<button type="button">Button</button>',
            Html::button('Button')->render()
        );
    }

    public function testSubmitButton(): void
    {
        $this->assertSame(
            '<button type="submit">Submit</button>',
            Html::submitButton('Submit')->render()
        );
    }

    public function testResetButton(): void
    {
        $this->assertSame(
            '<button type="reset">Reset</button>',
            Html::resetButton('Reset')->render()
        );
    }

    public function testInput(): void
    {
        self::assertSame('<input type="">', Html::input('')->render());
        self::assertSame('<input type="text">', Html::input('text')->render());
        self::assertSame('<input type="text" name="">', Html::input('text', '')->render());
        self::assertSame('<input type="text" value="">', Html::input('text', null, '')->render());
        self::assertSame('<input type="text" name="test">', Html::input('text', 'test')->render());
        self::assertSame(
            '<input type="text" name="test" value="43">',
            Html::input('text', 'test', '43')->render(),
        );
    }

    public function testButtonInput(): void
    {
        $this->assertSame('<input type="button" value="Button">', Html::buttonInput()->render());
        $this->assertSame('<input type="button">', Html::buttonInput(null)->render());
        $this->assertSame('<input type="button" value="">', Html::buttonInput('')->render());
        $this->assertSame('<input type="button" value="Go">', Html::buttonInput('Go')->render());
    }

    public function testSubmitInput(): void
    {
        $this->assertSame('<input type="submit" value="Submit">', Html::submitInput()->render());
        $this->assertSame('<input type="submit">', Html::submitInput(null)->render());
        $this->assertSame('<input type="submit" value="">', Html::submitInput('')->render());
        $this->assertSame('<input type="submit" value="Go">', Html::submitInput('Go')->render());
    }

    public function testResetInput(): void
    {
        $this->assertSame('<input type="reset" value="Reset">', Html::resetInput()->render());
        $this->assertSame('<input type="reset">', Html::resetInput(null)->render());
        $this->assertSame('<input type="reset" value="">', Html::resetInput('')->render());
        $this->assertSame('<input type="reset" value="Go">', Html::resetInput('Go')->render());
    }

    public function testTextInput(): void
    {
        $this->assertSame('<input type="text">', Html::textInput()->render());
        $this->assertSame('<input type="text" name="">', Html::textInput('')->render());
        $this->assertSame('<input type="text" value="">', Html::textInput(null, '')->render());
        $this->assertSame('<input type="text" name="test">', Html::textInput('test')->render());
        $this->assertSame(
            '<input type="text" name="test" value="43">',
            Html::textInput('test', '43')->render(),
        );
    }

    public function testHiddenInput(): void
    {
        $this->assertSame('<input type="hidden">', Html::hiddenInput()->render());
        $this->assertSame('<input type="hidden" name="">', Html::hiddenInput('')->render());
        $this->assertSame('<input type="hidden" value="">', Html::hiddenInput(null, '')->render());
        $this->assertSame('<input type="hidden" name="test">', Html::hiddenInput('test')->render());
        $this->assertSame(
            '<input type="hidden" name="test" value="43">',
            Html::hiddenInput('test', '43')->render(),
        );
    }

    public function testPasswordInput(): void
    {
        $this->assertSame('<input type="password">', Html::passwordInput()->render());
        $this->assertSame('<input type="password" name="">', Html::passwordInput('')->render());
        $this->assertSame('<input type="password" value="">', Html::passwordInput(null, '')->render());
        $this->assertSame('<input type="password" name="test">', Html::passwordInput('test')->render());
        $this->assertSame(
            '<input type="password" name="test" value="43">',
            Html::passwordInput('test', '43')->render(),
        );
    }

    public function testFileInput(): void
    {
        $this->assertSame('<input type="file">', Html::fileInput()->render());
        $this->assertSame('<input type="file" name="">', Html::fileInput('')->render());
        $this->assertSame('<input type="file" value="">', Html::fileInput(null, '')->render());
        $this->assertSame('<input type="file" name="test">', Html::fileInput('test')->render());
        $this->assertSame(
            '<input type="file" name="test" value="43">',
            Html::fileInput('test', '43')->render(),
        );
    }

    public function testRadioInput(): void
    {
        $this->assertSame('<input type="radio">', Html::radioInput()->render());
        $this->assertSame('<input type="radio" name="">', Html::radioInput('')->render());
        $this->assertSame('<input type="radio" value="">', Html::radioInput(null, '')->render());
        $this->assertSame('<input type="radio" name="test">', Html::radioInput('test')->render());
        $this->assertSame(
            '<input type="radio" name="test" value="43">',
            Html::radioInput('test', '43')->render(),
        );
    }

    public function testCheckboxInput(): void
    {
        $this->assertSame('<input type="checkbox">', Html::checkboxInput()->render());
        $this->assertSame('<input type="checkbox" name="">', Html::checkboxInput('')->render());
        $this->assertSame('<input type="checkbox" value="">', Html::checkboxInput(null, '')->render());
        $this->assertSame('<input type="checkbox" name="test">', Html::checkboxInput('test')->render());
        $this->assertSame(
            '<input type="checkbox" name="test" value="43">',
            Html::checkboxInput('test', '43')->render(),
        );
    }

    public function testSelect(): void
    {
        $this->assertSame('<select></select>', Html::select()->render());
        $this->assertSame('<select name=""></select>', Html::select('')->render());
        $this->assertSame('<select name="test"></select>', Html::select('test')->render());
    }

    public function testTextarea(): void
    {
        $this->assertSame('<textarea></textarea>', Html::textarea()->render());
        $this->assertSame('<textarea name=""></textarea>', Html::textarea('')->render());
        $this->assertSame('<textarea name="test"></textarea>', Html::textarea('test')->render());
        $this->assertSame('<textarea name="test">body</textarea>', Html::textarea('test', 'body')->render());
    }

    public function testRadio(): void
    {
        $this->assertSame('<input type="radio" name="test" value="1">', Html::radio('test'));
        $this->assertSame('<input type="radio" class="a" name="test" checked>', Html::radio('test', true, ['class' => 'a', 'value' => null]));
        $this->assertSame('<input type="hidden" name="test" value="0"><input type="radio" class="a" name="test" value="2" checked>', Html::radio('test', true, [
            'class' => 'a',
            'uncheck' => '0',
            'value' => 2,
        ]));
        $this->assertSame('<input type="hidden" name="test" value="0" disabled><input type="radio" name="test" value="2" disabled>', Html::radio('test', false, [
            'disabled' => true,
            'uncheck' => '0',
            'value' => 2,
        ]));

        $this->assertSame('<label class="bbb"><input type="radio" class="a" name="test" checked> ccc</label>', Html::radio('test', true, [
            'class' => 'a',
            'value' => null,
            'label' => 'ccc',
            'labelOptions' => ['class' => 'bbb'],
        ]));
        $this->assertSame('<input type="hidden" name="test" value="0"><label><input type="radio" class="a" name="test" value="2" checked> ccc</label>', Html::radio('test', true, [
            'class' => 'a',
            'uncheck' => '0',
            'label' => 'ccc',
            'value' => 2,
        ]));

        $this->assertSame(
            '<input type="radio" id="UseThis" name="test" checked> <label for="UseThis">Use this</label>',
            Html::radio('test', true, [
                'id' => 'UseThis',
                'label' => 'Use this',
                'value' => null,
                'wrapInput' => false,
            ])
        );

        self::$hrtimeResult = 42;
        $this->assertSame(
            '<input type="radio" id="i421" name="test" checked> <label for="i421">Use this</label>',
            Html::radio('test', true, [
                'label' => 'Use this',
                'value' => null,
                'wrapInput' => false,
            ])
        );
    }

    public function testCheckbox(): void
    {
        $this->assertSame('<input type="checkbox" name="test" value="1">', Html::checkbox('test'));
        $this->assertSame('<input type="checkbox" class="a" name="test" checked>', Html::checkbox('test', true, ['class' => 'a', 'value' => null]));
        $this->assertSame('<input type="hidden" name="test" value="0"><input type="checkbox" class="a" name="test" value="2" checked>', Html::checkbox('test', true, [
            'class' => 'a',
            'uncheck' => '0',
            'value' => 2,
        ]));
        $this->assertSame('<input type="hidden" name="test" value="0" disabled><input type="checkbox" name="test" value="2" disabled>', Html::checkbox('test', false, [
            'disabled' => true,
            'uncheck' => '0',
            'value' => 2,
        ]));

        $this->assertSame('<label class="bbb"><input type="checkbox" class="a" name="test" checked> ccc</label>', Html::checkbox('test', true, [
            'class' => 'a',
            'value' => null,
            'label' => 'ccc',
            'labelOptions' => ['class' => 'bbb'],
        ]));
        $this->assertSame('<input type="hidden" name="test" value="0"><label><input type="checkbox" class="a" name="test" value="2" checked> ccc</label>', Html::checkbox('test', true, [
            'class' => 'a',
            'uncheck' => '0',
            'label' => 'ccc',
            'value' => 2,
        ]));
        $this->assertSame('<input type="hidden" name="test" value="0" form="test-form"><label><input type="checkbox" class="a" name="test" value="2" form="test-form" checked> ccc</label>', Html::checkbox('test', true, [
            'class' => 'a',
            'uncheck' => '0',
            'label' => 'ccc',
            'value' => 2,
            'form' => 'test-form',
        ]));

        $this->assertSame(
            '<input type="checkbox" id="UseThis" name="test"> <label for="UseThis">Use this</label>',
            Html::checkbox('test', false, [
                'id' => 'UseThis',
                'label' => 'Use this',
                'value' => null,
                'wrapInput' => false,
            ])
        );

        self::$hrtimeResult = 49;
        $this->assertSame(
            '<input type="checkbox" id="i491" name="test"> <label for="i491">Use this</label>',
            Html::checkbox('test', false, [
                'label' => 'Use this',
                'value' => null,
                'wrapInput' => false,
            ])
        );
    }

    public function testCheckboxList(): void
    {
        $this->assertSame('<div></div>', Html::checkboxList('test'));

        $expected = <<<'EOD'
<div><label><input type="checkbox" name="test[]" value="value1"> text1</label>
<label><input type="checkbox" name="test[]" value="value2" checked> text2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['value2'], $this->getDataItems()));
        $this->assertSameWithoutLE($expected, Html::checkboxList('test[]', ['value2'], $this->getDataItems()));
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', 'value2', $this->getDataItems()));

        $expected = <<<'EOD'
<div><label><input type="checkbox" name="test[]" value="value1&lt;&gt;"> text1&lt;&gt;</label>
<label><input type="checkbox" name="test[]" value="value  2"> text  2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['value2'], $this->getDataItems2()));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="0"><div><label><input type="checkbox" name="test[]" value="value1"> text1</label><br>
<label><input type="checkbox" name="test[]" value="value2" checked> text2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['value2'], $this->getDataItems(), [
            'separator' => "<br>\n",
            'unselect' => '0',
        ]));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="0" disabled><div><label><input type="checkbox" name="test[]" value="value1"> text1</label><br>
<label><input type="checkbox" name="test[]" value="value2"> text2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', null, $this->getDataItems(), [
            'separator' => "<br>\n",
            'unselect' => '0',
            'disabled' => true,
        ]));

        $expected = <<<'EOD'
<div>0<label>text1 <input type="checkbox" name="test[]" value="value1"></label>
1<label>text2 <input type="checkbox" name="test[]" value="value2" checked></label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['value2'], $this->getDataItems(), [
            'item' => static function ($index, $label, $name, $checked, $value) {
                return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]))->withoutEncode();
            },
        ]));

        $expected = <<<'EOD'
0<label>text1 <input type="checkbox" name="test[]" value="value1"></label>
1<label>text2 <input type="checkbox" name="test[]" value="value2" checked></label>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['value2'], $this->getDataItems(), [
            'item' => static function ($index, $label, $name, $checked, $value) {
                return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]))->withoutEncode();
            },
            'tag' => false,
        ]));
        $this->assertSameWithoutLE(
            $expected,
            Html::checkboxList('test', new ArrayObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]))->withoutEncode();
                },
                'tag' => false,
            ])
        );
        $this->assertSameWithoutLE(
            $expected,
            Html::checkboxList('test', new IterableObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]))->withoutEncode();
                },
                'tag' => false,
            ])
        );

        $expected = <<<'EOD'
<div><label><input type="checkbox" name="test[]" value="0" checked> zero</label>
<label><input type="checkbox" name="test[]" value="1"> one</label>
<label><input type="checkbox" name="test[]" value="value3"> text3</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', [0], $this->getDataItems3()));
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', new ArrayObject([0]), $this->getDataItems3()));

        $expected = <<<'EOD'
<div><label><input type="checkbox" name="test[]" value="0"> zero</label>
<label><input type="checkbox" name="test[]" value="1" checked> one</label>
<label><input type="checkbox" name="test[]" value="value3" checked> text3</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['1', 'value3'], $this->getDataItems3()));
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', new ArrayObject(['1', 'value3']), $this->getDataItems3()));

        $expected = <<<'EOD'
<div><label><input type="checkbox" name="test[]" value="0" any="42"> zero</label>
<label><input type="checkbox" name="test[]" value="1" checked any="42"> one</label>
<label><input type="checkbox" name="test[]" value="value3" any="42"> text3</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList(
            'test',
            1,
            $this->getDataItems3(),
            ['itemOptions' => ['any' => 42]]
        ));
    }

    public function testRadioList(): void
    {
        $this->assertSame('<div></div>', Html::radioList('test'));

        $this->assertSame(
            '<input type="hidden" name="test" value="1"><label><input type="radio" name="test" value="1"> a</label>',
            Html::radioList('test', null, [1 => 'a'], ['unselect' => 1, 'tag' => false])
        );

        $expected = <<<'EOD'
<div><label><input type="radio" name="test" value="value1"> text1</label>
<label><input type="radio" name="test" value="value2" checked> text2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value2'], $this->getDataItems()));

        $expected = <<<'EOD'
<div><label><input type="radio" name="test" value="value1&lt;&gt;"> text1&lt;&gt;</label>
<label><input type="radio" name="test" value="value  2"> text  2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value2'], $this->getDataItems2()));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="0"><div><label><input type="radio" name="test" value="value1"> text1</label><br>
<label><input type="radio" name="test" value="value2" checked> text2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value2'], $this->getDataItems(), [
            'separator' => "<br>\n",
            'unselect' => '0',
        ]));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="0" disabled><div><label><input type="radio" name="test" value="value1"> text1</label><br>
<label><input type="radio" name="test" value="value2"> text2</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', null, $this->getDataItems(), [
            'separator' => "<br>\n",
            'unselect' => '0',
            'disabled' => true,
        ]));

        $expected = <<<'EOD'
<div>0<label>text1 <input type="radio" name="test" value="value1"></label>
1<label>text2 <input type="radio" name="test" value="value2" checked></label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value2'], $this->getDataItems(), [
            'item' => static function ($index, $label, $name, $checked, $value) {
                return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]))->withoutEncode();
            },
        ]));

        $expected = <<<'EOD'
0<label>text1 <input type="radio" name="test" value="value1"></label>
1<label>text2 <input type="radio" name="test" value="value2" checked></label>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value2'], $this->getDataItems(), [
            'item' => static function ($index, $label, $name, $checked, $value) {
                return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]))->withoutEncode();
            },
            'tag' => false,
        ]));
        $this->assertSameWithoutLE(
            $expected,
            Html::radioList('test', new ArrayObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]))->withoutEncode();
                },
                'tag' => false,
            ])
        );
        $this->assertSameWithoutLE(
            $expected,
            Html::radioList('test', new IterableObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]))->withoutEncode();
                },
                'tag' => false,
            ])
        );

        $expected = <<<'EOD'
<div><label><input type="radio" name="test" value="0" checked> zero</label>
<label><input type="radio" name="test" value="1"> one</label>
<label><input type="radio" name="test" value="value3"> text3</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', [0], $this->getDataItems3()));
        $this->assertSameWithoutLE($expected, Html::radioList('test', new ArrayObject([0]), $this->getDataItems3()));

        $expected = <<<'EOD'
<div><label><input type="radio" name="test" value="0"> zero</label>
<label><input type="radio" name="test" value="1"> one</label>
<label><input type="radio" name="test" value="value3" checked> text3</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value3'], $this->getDataItems3()));
        $this->assertSameWithoutLE($expected, Html::radioList('test', new ArrayObject(['value3']), $this->getDataItems3()));

        $expected = <<<'EOD'
<div><label><input type="radio" name="test" value="1" checked any="42"> One</label>
<label><input type="radio" name="test" value="2" any="42"> Two</label></div>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList(
            'test',
            1,
            [1 => 'One', 2 => 'Two'],
            ['itemOptions' => ['any' => 42]]
        ));
    }

    public function testDiv(): void
    {
        $this->assertSame('<div></div>', Html::div()->render());
        $this->assertSame('<div>hello</div>', Html::div('hello')->render());
    }

    public function testSpan(): void
    {
        $this->assertSame('<span></span>', Html::span()->render());
        $this->assertSame('<span>hello</span>', Html::span('hello')->render());
    }

    public function testP(): void
    {
        $this->assertSame('<p></p>', Html::p()->render());
        $this->assertSame('<p>hello</p>', Html::p('hello')->render());
    }

    public function testUl(): void
    {
        self::assertSame('<ul></ul>', Html::ul()->render());
    }

    public function testOl(): void
    {
        self::assertSame('<ol></ol>', Html::ol()->render());
    }

    public function testLi(): void
    {
        self::assertSame('<li></li>', Html::li()->render());
        self::assertSame('<li>hello</li>', Html::li('hello')->render());
    }

    public function testRenderAttributes(): void
    {
        $this->assertSame('', Html::renderTagAttributes([]));
        $this->assertSame(' name="test" value="1&lt;&gt;"', Html::renderTagAttributes(['name' => 'test', 'empty' => null, 'value' => '1<>']));
        $this->assertSame(' checked disabled', Html::renderTagAttributes(['checked' => true, 'disabled' => true, 'hidden' => false]));
        $this->assertSame(' class="first second"', Html::renderTagAttributes(['class' => ['first', 'second']]));
        $this->assertSame('', Html::renderTagAttributes(['class' => []]));
        $this->assertSame(' style="width: 100px; height: 200px;"', Html::renderTagAttributes(['style' => ['width' => '100px', 'height' => '200px']]));
        $this->assertSame('', Html::renderTagAttributes(['style' => []]));
        $this->assertSame(
            ' id="x" class="a b" data-a="1" data-b="2" style="width: 100px;" any=\'[1,2]\'',
            Html::renderTagAttributes([
                'id' => 'x',
                'class' => ['a', 'b'],
                'data' => ['a' => 1, 'b' => 2],
                'style' => ['width' => '100px'],
                'any' => [1, 2],
            ])
        );
        $this->assertSame(' data-a="0" data-b=\'[1,2]\' any="42"', Html::renderTagAttributes([
            'class' => [],
            'style' => [],
            'data' => ['a' => 0, 'b' => [1, 2]],
            'any' => 42,
        ]));

        $attributes = [
            'data' => [
                'foo' => [],
            ],
        ];
        $this->assertSame(' data-foo=\'[]\'', Html::renderTagAttributes($attributes));
    }

    public function testAddCssClass(): void
    {
        $options = [];
        Html::addCssClass($options, 'test');
        $this->assertSame(['class' => 'test'], $options);
        Html::addCssClass($options, 'test');
        $this->assertSame(['class' => 'test'], $options);
        Html::addCssClass($options, 'test2');
        $this->assertSame(['class' => 'test test2'], $options);
        Html::addCssClass($options, 'test');
        $this->assertSame(['class' => 'test test2'], $options);
        Html::addCssClass($options, 'test2');
        $this->assertSame(['class' => 'test test2'], $options);
        Html::addCssClass($options, 'test3');
        $this->assertSame(['class' => 'test test2 test3'], $options);
        Html::addCssClass($options, 'test2');
        $this->assertSame(['class' => 'test test2 test3'], $options);

        $options = [
            'class' => ['test'],
        ];
        Html::addCssClass($options, 'test2');
        $this->assertSame(['class' => ['test', 'test2']], $options);
        Html::addCssClass($options, 'test2');
        $this->assertSame(['class' => ['test', 'test2']], $options);
        Html::addCssClass($options, ['test3']);
        $this->assertSame(['class' => ['test', 'test2', 'test3']], $options);

        $options = [
            'class' => 'test',
        ];
        Html::addCssClass($options, ['test1', 'test2']);
        $this->assertSame(['class' => 'test test1 test2'], $options);

        $options = [
            'class' => 'test test',
        ];
        Html::addCssClass($options, 'test2');
        $this->assertSame(['class' => 'test test2'], $options);
    }

    /**
     * @depends testAddCssClass
     */
    public function testMergeCssClass(): void
    {
        $options = [
            'class' => [
                'persistent' => 'test1',
            ],
        ];
        Html::addCssClass($options, ['persistent' => 'test2']);
        $this->assertSame(['persistent' => 'test1'], $options['class']);
        Html::addCssClass($options, ['additional' => 'test2']);
        $this->assertSame(['persistent' => 'test1', 'additional' => 'test2'], $options['class']);
    }

    public function testRemoveCssClass(): void
    {
        $options = ['class' => 'test test2 test3'];
        Html::removeCssClass($options, 'test2');
        $this->assertSame(['class' => 'test test3'], $options);
        Html::removeCssClass($options, 'test2');
        $this->assertSame(['class' => 'test test3'], $options);
        Html::removeCssClass($options, 'test');
        $this->assertSame(['class' => 'test3'], $options);
        Html::removeCssClass($options, 'test3');
        $this->assertSame([], $options);

        $options = ['class' => ['test', 'test2', 'test3']];
        Html::removeCssClass($options, 'test2');
        $this->assertSame(['class' => ['test', 2 => 'test3']], $options);
        Html::removeCssClass($options, 'test');
        Html::removeCssClass($options, 'test3');
        $this->assertSame([], $options);

        $options = [
            'class' => 'test test1 test2',
        ];
        Html::removeCssClass($options, ['test1', 'test2']);
        $this->assertSame(['class' => 'test'], $options);
    }

    public function testCssStyleFromArray(): void
    {
        $this->assertSame('width: 100px; height: 200px;', Html::cssStyleFromArray([
            'width' => '100px',
            'height' => '200px',
        ]));
        $this->assertNull(Html::cssStyleFromArray([]));
    }

    public function testCssStyleToArray(): void
    {
        $this->assertSame([
            'width' => '100px',
            'height' => '200px',
        ], Html::cssStyleToArray('width: 100px; height: 200px;'));
        $this->assertSame([], Html::cssStyleToArray('  '));
    }

    public function testAddCssStyle(): void
    {
        $options = ['style' => 'width: 100px; height: 200px;'];
        Html::addCssStyle($options, 'width: 110px; color: red;');
        $this->assertSame('width: 110px; height: 200px; color: red;', $options['style']);

        $options = ['style' => 'width: 100px; height: 200px;'];
        Html::addCssStyle($options, ['width' => '110px', 'color' => 'red']);
        $this->assertSame('width: 110px; height: 200px; color: red;', $options['style']);

        $options = ['style' => 'width: 100px; height: 200px;'];
        Html::addCssStyle($options, 'width: 110px; color: red;', false);
        $this->assertSame('width: 100px; height: 200px; color: red;', $options['style']);

        $options = [];
        Html::addCssStyle($options, 'width: 110px; color: red;');
        $this->assertSame('width: 110px; color: red;', $options['style']);

        $options = [];
        Html::addCssStyle($options, 'width: 110px; color: red;', false);
        $this->assertSame('width: 110px; color: red;', $options['style']);

        $options = [
            'style' => [
                'width' => '100px',
            ],
        ];
        Html::addCssStyle($options, ['color' => 'red'], false);
        $this->assertSame('width: 100px; color: red;', $options['style']);
    }

    public function testRemoveCssStyle(): void
    {
        $options = ['style' => 'width: 110px; height: 200px; color: red;'];
        Html::removeCssStyle($options, 'width');
        $this->assertSame('height: 200px; color: red;', $options['style']);
        Html::removeCssStyle($options, ['height']);
        $this->assertSame('color: red;', $options['style']);
        Html::removeCssStyle($options, ['color', 'background']);
        $this->assertNull($options['style']);

        $options = [];
        Html::removeCssStyle($options, ['color', 'background']);
        $this->assertNotTrue(array_key_exists('style', $options));
        $options = [
            'style' => [
                'color' => 'red',
                'width' => '100px',
            ],
        ];
        Html::removeCssStyle($options, ['color']);
        $this->assertSame('width: 100px;', $options['style']);
    }

    public function testDataAttributes(): void
    {
        $this->assertSame('<link src="xyz" data-a="1" data-b="c">', Html::tag('link', '', ['src' => 'xyz', 'data' => ['a' => 1, 'b' => 'c']]));
        $this->assertSame('<link src="xyz" ng-a="1" ng-b="c">', Html::tag('link', '', ['src' => 'xyz', 'ng' => ['a' => 1, 'b' => 'c']]));
        $this->assertSame('<link src="xyz" data-ng-a="1" data-ng-b="c">', Html::tag('link', '', ['src' => 'xyz', 'data-ng' => ['a' => 1, 'b' => 'c']]));
        $this->assertSame('<link src="xyz" aria-a="1" aria-b="c">', Html::tag('link', '', ['src' => 'xyz', 'aria' => ['a' => 1, 'b' => 'c']]));
        $this->assertSame('<link src=\'{"a":1,"b":"It\\u0027s"}\'>', Html::tag('link', '', ['src' => ['a' => 1, 'b' => "It's"]]));
    }

    private function getDataItems(): array
    {
        return [
            'value1' => 'text1',
            'value2' => 'text2',
        ];
    }

    private function getDataItems2(): array
    {
        return [
            'value1<>' => 'text1<>',
            'value  2' => 'text  2',
        ];
    }

    private function getDataItems3(): array
    {
        return [
            'zero',
            'one',
            'value3' => 'text3',
        ];
    }

    public function dataNormalizeRegexpPattern(): array
    {
        return [
            ['', '//'],
            ['.*', '/.*/'],
            ['([a-z0-9-]+)', '/([a-z0-9-]+)/Ugimex'],
            ['([a-z0-9-]+)', '~([a-z0-9-]+)~Ugimex'],
            ['([a-z0-9-]+)', '~([a-z0-9-]+)~Ugimex', '~'],
            ['\u1F596([a-z])', '/\x{1F596}([a-z])/i'],
        ];
    }

    /**
     * @dataProvider dataNormalizeRegexpPattern
     *
     * @param string $expected
     * @param string $regexp
     * @param string|null $delimiter
     */
    public function testNormalizeRegexpPattern(string $expected, string $regexp, ?string $delimiter = null): void
    {
        $this->assertSame($expected, Html::normalizeRegexpPattern($regexp, $delimiter));
    }

    public function dataNormalizeRegexpPatternInvalid(): array
    {
        return [
            [''],
            ['.*'],
            ['/.*'],
            ['([a-z0-9-]+)'],
            ['/.*/i', '~'],
            ['/.*/i', '//'],
            ['/~~/i', '~~'],
        ];
    }

    /**
     * @dataProvider dataNormalizeRegexpPatternInvalid
     *
     * @param string $regexp
     * @param string|null $delimiter
     */
    public function testNormalizeRegexpPatternInvalid(string $regexp, ?string $delimiter = null): void
    {
        $this->expectException(InvalidArgumentException::class);
        Html::normalizeRegexpPattern($regexp, $delimiter);
    }
}

namespace Yiisoft\Html;

use Yiisoft\Html\Tests\HtmlTest;

function hrtime(bool $getAsNumber = false)
{
    return HtmlTest::$hrtimeResult ?? \hrtime($getAsNumber);
}
