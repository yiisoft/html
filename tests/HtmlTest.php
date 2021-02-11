<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use ArrayObject;
use InvalidArgumentException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tests\Objects\ArrayAccessObject;
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
        $content = 'a <>';
        $this->assertSame("<style>{$content}</style>", Html::style($content));
        $this->assertSame("<style type=\"text/less\">{$content}</style>", Html::style($content, ['type' => 'text/less']));
    }

    public function testScript(): void
    {
        $content = 'a <>';
        $this->assertSame("<script>{$content}</script>", Html::script($content));
        $this->assertSame("<script type=\"text/js\">{$content}</script>", Html::script($content, ['type' => 'text/js']));
    }

    public function testCssFile(): void
    {
        $this->assertSame('<link href="http://example.com" rel="stylesheet">', Html::cssFile('http://example.com'));
        $this->assertSame('<link href="" rel="stylesheet">', Html::cssFile(''));
        $this->assertSame('<noscript><link href="http://example.com" rel="stylesheet"></noscript>', Html::cssFile('http://example.com', ['noscript' => true]));
    }

    public function testJsFile(): void
    {
        $this->assertSame('<script src="http://example.com"></script>', Html::javaScriptFile('http://example.com'));
        $this->assertSame('<script src=""></script>', Html::javaScriptFile(''));
    }

    public function testA(): void
    {
        $this->assertSame('<a href="#">link</a>', Html::a()->url('#')->content('link')->render());
    }

    /**
     * @return array
     */
    public function imgDataProvider(): array
    {
        return [
            [
                '<img src="/example" alt="">',
                '/example',
                [],
            ],
            [
                '<img src="" alt="">',
                '',
                [],
            ],
            [
                '<img src="/example" width="10" alt="something">',
                '/example',
                [
                    'alt' => 'something',
                    'width' => 10,
                ],
            ],
            [
                '<img src="/base-url" srcset="" alt="">',
                '/base-url',
                [
                    'srcset' => [
                    ],
                ],
            ],
            [
                '<img src="/base-url" srcset="/example-9001w 9001w" alt="">',
                '/base-url',
                [
                    'srcset' => [
                        '9001w' => '/example-9001w',
                    ],
                ],
            ],
            [
                '<img src="/base-url" srcset="/example-100w 100w,/example-500w 500w,/example-1500w 1500w" alt="">',
                '/base-url',
                [
                    'srcset' => [
                        '100w' => '/example-100w',
                        '500w' => '/example-500w',
                        '1500w' => '/example-1500w',
                    ],
                ],
            ],
            [
                '<img src="/base-url" srcset="/example-1x 1x,/example-2x 2x,/example-3x 3x,/example-4x 4x,/example-5x 5x" alt="">',
                '/base-url',
                [
                    'srcset' => [
                        '1x' => '/example-1x',
                        '2x' => '/example-2x',
                        '3x' => '/example-3x',
                        '4x' => '/example-4x',
                        '5x' => '/example-5x',
                    ],
                ],
            ],
            [
                '<img src="/base-url" srcset="/example-1.42x 1.42x,/example-2.0x 2.0x,/example-3.99999x 3.99999x" alt="">',
                '/base-url',
                [
                    'srcset' => [
                        '1.42x' => '/example-1.42x',
                        '2.0x' => '/example-2.0x',
                        '3.99999x' => '/example-3.99999x',
                    ],
                ],
            ],
            [
                '<img src="/base-url" srcset="/example-1x 1x,/example-2x 2x,/example-3x 3x" alt="">',
                '/base-url',
                [
                    'srcset' => '/example-1x 1x,/example-2x 2x,/example-3x 3x',
                ],
            ],
        ];
    }

    /**
     * @dataProvider imgDataProvider
     *
     * @param string $expected
     * @param string $src
     * @param array $options
     */
    public function testImg(string $expected, string $src, array $options): void
    {
        $this->assertSame($expected, Html::img($src, $options));
    }

    public function testLabel(): void
    {
        $this->assertSame('<label>something<></label>', Html::label('something<>'));
        $this->assertSame('<label for="a">something<></label>', Html::label('something<>', 'a'));
        $this->assertSame('<label class="test" for="a">something<></label>', Html::label('something<>', 'a', ['class' => 'test']));
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
        $this->assertSame('<input type="text">', Html::input('text'));
        $this->assertSame('<input type="text" class="t" name="test" value="value">', Html::input('text', 'test', 'value', ['class' => 't']));
    }

    public function testButtonInput(): void
    {
        $this->assertSame('<input type="button" value="Button">', Html::buttonInput());
        $this->assertSame('<input type="button" class="a" name="test" value="text">', Html::buttonInput('text', ['name' => 'test', 'class' => 'a']));
    }

    public function testSubmitInput(): void
    {
        $this->assertSame('<input type="submit" value="Submit">', Html::submitInput());
        $this->assertSame('<input type="submit" class="a" name="test" value="text">', Html::submitInput('text', ['name' => 'test', 'class' => 'a']));
    }

    public function testResetInput(): void
    {
        $this->assertSame('<input type="reset" value="Reset">', Html::resetInput());
        $this->assertSame('<input type="reset" class="a" name="test" value="text">', Html::resetInput('text', ['name' => 'test', 'class' => 'a']));
    }

    public function testTextInput(): void
    {
        $this->assertSame('<input type="text" name="test">', Html::textInput('test'));
        $this->assertSame('<input type="text" class="t" name="test" value="value">', Html::textInput('test', 'value', ['class' => 't']));
    }

    public function testHiddenInput(): void
    {
        $this->assertSame('<input type="hidden" name="test">', Html::hiddenInput('test'));
        $this->assertSame('<input type="hidden" class="t" name="test" value="value">', Html::hiddenInput('test', 'value', ['class' => 't']));
    }

    public function testPasswordInput(): void
    {
        $this->assertSame('<input type="password" name="test">', Html::passwordInput('test'));
        $this->assertSame('<input type="password" class="t" name="test" value="value">', Html::passwordInput('test', 'value', ['class' => 't']));
    }

    public function testFileInput(): void
    {
        $this->assertSame('<input type="file" name="test">', Html::fileInput('test'));
        $this->assertSame('<input type="file" class="t" name="test" value="value">', Html::fileInput('test', 'value', ['class' => 't']));
    }

    /**
     * @return array
     */
    public function textareaDataProvider(): array
    {
        return [
            [
                '<textarea name="test"></textarea>',
                'test',
                null,
                [],
            ],
            [
                '<textarea class="t" name="test">value&lt;&gt;</textarea>',
                'test',
                'value<>',
                ['class' => 't'],
            ],
            [
                '<textarea name="test">value&amp;lt;&amp;gt;</textarea>',
                'test',
                'value&lt;&gt;',
                [],
            ],
            [
                '<textarea name="test">value&lt;&gt;</textarea>',
                'test',
                'value&lt;&gt;',
                ['doubleEncode' => false],
            ],
        ];
    }

    /**
     * @dataProvider textareaDataProvider
     *
     * @param string $expected
     * @param string $name
     * @param string $value
     * @param array $options
     */
    public function testTextarea($expected, $name, $value, $options): void
    {
        $this->assertSame($expected, Html::textarea($name, $value, $options));
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

    public function testDropDownList(): void
    {
        $expected = <<<'EOD'
<select name="test">

</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test'));
        $expected = <<<'EOD'
<select name="test">
<option value="value1">text1</option>
<option value="value2">text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', null, $this->getDataItems()));
        $expected = <<<'EOD'
<select name="test">
<option value="value1">text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', 'value2', $this->getDataItems()));

        $expected = <<<'EOD'
<select name="test">
<option value="value1">text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', null, $this->getDataItems(), [
            'options' => [
                'value2' => ['selected' => true],
            ],
        ]));

        $expected = <<<'EOD'
<select name="test[]" multiple="true" size="4">

</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', null, [], ['multiple' => 'true']));

        $expected = <<<'EOD'
<select name="test[]" multiple="true" size="4">
<option value="0" selected>zero</option>
<option value="1">one</option>
<option value="value3">text3</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', [0], $this->getDataItems3(), ['multiple' => 'true']));
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', new ArrayObject([0]), $this->getDataItems3(), ['multiple' => 'true']));

        $expected = <<<'EOD'
<select name="test[]" multiple="true" size="4">
<option value="0">zero</option>
<option value="1" selected>one</option>
<option value="value3" selected>text3</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', ['1', 'value3'], $this->getDataItems3(), ['multiple' => 'true']));
        $this->assertSameWithoutLE($expected, Html::dropDownList('test', new ArrayObject(['1', 'value3']), $this->getDataItems3(), ['multiple' => 'true']));
    }

    public function testListBox(): void
    {
        $expected = <<<'EOD'
<select name="test" size="4">

</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test'));
        $expected = <<<'EOD'
<select name="test" size="5">
<option value="value1">text1</option>
<option value="value2">text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', null, $this->getDataItems(), ['size' => 5]));
        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text  2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', null, $this->getDataItems2()));
        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1&lt;&gt;">text1&lt;&gt;</option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', null, $this->getDataItems2(), ['encodeSpaces' => true]));
        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text  2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', null, $this->getDataItems2(), ['encode' => false]));
        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1&lt;&gt;">text1<></option>
<option value="value  2">text&nbsp;&nbsp;2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', null, $this->getDataItems2(), ['encodeSpaces' => true, 'encode' => false]));
        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1">text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', 'value2', $this->getDataItems()));
        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1" selected>text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', ['value1', 'value2'], $this->getDataItems()));

        $expected = <<<'EOD'
<select name="test[]" multiple size="4">

</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', null, [], ['multiple' => true]));
        $this->assertSameWithoutLE($expected, Html::listBox('test[]', null, [], ['multiple' => true]));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="0"><select name="test" size="4">

</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', '', [], ['unselect' => '0']));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="0" disabled><select name="test" disabled size="4">

</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', '', [], ['unselect' => '0', 'disabled' => true]));

        $expected = <<<'EOD'
<select name="test" size="4">
<option value="value1" selected>text1</option>
<option value="value2" selected>text2</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', new ArrayObject(['value1', 'value2']), $this->getDataItems()));

        $expected = <<<'EOD'
<select name="test" size="4">
<option value="0" selected>zero</option>
<option value="1">one</option>
<option value="value3">text3</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', [0], $this->getDataItems3()));
        $this->assertSameWithoutLE($expected, Html::listBox('test', new ArrayObject([0]), $this->getDataItems3()));

        $expected = <<<'EOD'
<select name="test" size="4">
<option value="0">zero</option>
<option value="1" selected>one</option>
<option value="value3" selected>text3</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox('test', ['1', 'value3'], $this->getDataItems3()));
        $this->assertSameWithoutLE($expected, Html::listBox('test', new ArrayObject(['1', 'value3']), $this->getDataItems3()));

        $expected = <<<'EOD'
<input type="hidden" name="test" value="none"><select name="test[]" size="4">
<option value="0">zero</option>
<option value="1" selected>one</option>
<option value="value3" selected>text3</option>
</select>
EOD;
        $this->assertSameWithoutLE($expected, Html::listBox(
            'test[]',
            ['1', 'value3'],
            $this->getDataItems3(),
            ['unselect' => 'none'],
        ));
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
                return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]));
            },
        ]));

        $expected = <<<'EOD'
0<label>text1 <input type="checkbox" name="test[]" value="value1"></label>
1<label>text2 <input type="checkbox" name="test[]" value="value2" checked></label>
EOD;
        $this->assertSameWithoutLE($expected, Html::checkboxList('test', ['value2'], $this->getDataItems(), [
            'item' => static function ($index, $label, $name, $checked, $value) {
                return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]));
            },
            'tag' => false,
        ]));
        $this->assertSameWithoutLE(
            $expected,
            Html::checkboxList('test', new ArrayObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]));
                },
                'tag' => false,
            ])
        );
        $this->assertSameWithoutLE(
            $expected,
            Html::checkboxList('test', new IterableObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::checkbox($name, $checked, ['value' => $value]));
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
                return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]));
            },
        ]));

        $expected = <<<'EOD'
0<label>text1 <input type="radio" name="test" value="value1"></label>
1<label>text2 <input type="radio" name="test" value="value2" checked></label>
EOD;
        $this->assertSameWithoutLE($expected, Html::radioList('test', ['value2'], $this->getDataItems(), [
            'item' => static function ($index, $label, $name, $checked, $value) {
                return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]));
            },
            'tag' => false,
        ]));
        $this->assertSameWithoutLE(
            $expected,
            Html::radioList('test', new ArrayObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]));
                },
                'tag' => false,
            ])
        );
        $this->assertSameWithoutLE(
            $expected,
            Html::radioList('test', new IterableObject(['value2']), $this->getDataItems(), [
                'item' => static function ($index, $label, $name, $checked, $value) {
                    return $index . Html::label($label . ' ' . Html::radio($name, $checked, ['value' => $value]));
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
        $this->assertSame('<div class="red">hello</div>', Html::div('hello', ['class' => 'red']));
    }

    public function testSpan(): void
    {
        $this->assertSame('<span class="red">hello</span>', Html::span('hello', ['class' => 'red']));
    }

    public function testP(): void
    {
        $this->assertSame('<p class="red">hello</p>', Html::p('hello', ['class' => 'red']));
    }

    public function testUl(): void
    {
        $data = [1, 'abc', '<>'];
        $expected = <<<'EOD'
<ul>
<li>1</li>
<li>abc</li>
<li>&lt;&gt;</li>
</ul>
EOD;
        $this->assertSameWithoutLE($expected, Html::ul($data));
        $expected = <<<'EOD'
<ul class="test">
<li class="item-0">1</li>
<li class="item-1">abc</li>
<li class="item-2"><></li>
</ul>
EOD;
        $this->assertSameWithoutLE($expected, Html::ul($data, [
            'class' => 'test',
            'item' => static function ($item, $index) {
                return "<li class=\"item-$index\">$item</li>";
            },
        ]));

        $this->assertSame('<ul class="test"></ul>', Html::ul([], ['class' => 'test']));

        $this->assertStringMatchesFormat('<foo>%A</foo>', Html::ul([], ['tag' => 'foo']));

        $expected = <<<EOD
<ul>
<li>1</li>
<li>2</li>
<li>3</li>
</ul>
EOD;
        $this->assertSameWithoutLE($expected, Html::ul(new ArrayAccessObject()));
    }

    public function testOl(): void
    {
        $data = [1, 'abc', '<>'];
        $expected = <<<'EOD'
<ol>
<li class="ti">1</li>
<li class="ti">abc</li>
<li class="ti">&lt;&gt;</li>
</ol>
EOD;
        $this->assertSameWithoutLE($expected, Html::ol($data, [
            'itemOptions' => ['class' => 'ti'],
        ]));
        $expected = <<<'EOD'
<ol class="test">
<li class="item-0">1</li>
<li class="item-1">abc</li>
<li class="item-2"><></li>
</ol>
EOD;
        $this->assertSameWithoutLE($expected, Html::ol($data, [
            'class' => 'test',
            'item' => static function ($item, $index) {
                return "<li class=\"item-$index\">$item</li>";
            },
        ]));

        $this->assertSame('<ol class="test"></ol>', Html::ol([], ['class' => 'test']));

        $expected = <<<EOD
<ol>
<li>1</li>
<li>2</li>
<li>3</li>
</ol>
EOD;
        $this->assertSameWithoutLE($expected, Html::ol(new ArrayAccessObject()));
    }

    public function testRenderSelectOptions(): void
    {
        $data = [
            'value1' => 'label1',
            'group1' => [
                'value11' => 'label11',
                'group11' => [
                    'value111' => 'label111',
                ],
                'group12' => [],
            ],
            'value2' => 'label2',
            'group2' => [],
        ];
        $expected = <<<'EOD'
<option value="">please&nbsp;select&lt;&gt;</option>
<option value="value1" selected>label1</option>
<optgroup label="group1">
<option value="value11">label11</option>
<optgroup label="group11">
<option class="option" value="value111" selected>label111</option>
</optgroup>
<optgroup class="group" label="group12">

</optgroup>
</optgroup>
<option value="value2">label2</option>
<optgroup label="group2">

</optgroup>
EOD;
        $attributes = [
            'prompt' => 'please select<>',
            'options' => [
                'value111' => ['class' => 'option'],
            ],
            'groups' => [
                'group12' => ['class' => 'group'],
            ],
            'encodeSpaces' => true,
        ];
        $this->assertSameWithoutLE($expected, Html::renderSelectOptions(['value111', 'value1'], $data, $attributes));
        $this->assertSameWithoutLE($expected, Html::renderSelectOptions(new ArrayObject(['value111', 'value1']), $data, $attributes));
        $this->assertSameWithoutLE($expected, Html::renderSelectOptions(new IterableObject(['value111', 'value1']), $data, $attributes));

        $attributes = [
            'prompt' => 'please select<>',
            'options' => [
                'value111' => ['class' => 'option'],
            ],
            'groups' => [
                'group12' => ['class' => 'group'],
            ],
        ];
        $this->assertSameWithoutLE(str_replace('&nbsp;', ' ', $expected), Html::renderSelectOptions(['value111', 'value1'], $data, $attributes));

        // Attributes for prompt (https://github.com/yiisoft/yii2/issues/7420)

        $data = [
            'value1' => 'label1',
            'value2' => 'label2',
        ];
        $expected = <<<'EOD'
<option class="prompt" value="-1" label="None">Please select</option>
<option value="value1" selected>label1</option>
<option value="value2">label2</option>
EOD;
        $attributes = [
            'prompt' => [
                'text' => 'Please select',
                'options' => ['class' => 'prompt', 'value' => '-1', 'label' => 'None'],
            ],
        ];
        $this->assertSameWithoutLE($expected, Html::renderSelectOptions(['value1'], $data, $attributes));

        $data = [1 => 'One', 2 => 'Two'];
        $expected = <<<'EOD'
<option class="prompt" value="" label="None">Please select</option>
<option value="1" selected>One</option>
<option value="2">Two</option>
EOD;
        $attributes = [
            'prompt' => [
                'text' => 'Please select',
                'options' => ['class' => 'prompt', 'label' => 'None'],
            ],
        ];
        $this->assertSameWithoutLE($expected, Html::renderSelectOptions(1, $data, $attributes));

        $expected = <<<'EOD'
<option value="encode">1</option>
<option value="encodeSpaces">2</option>
EOD;
        $data = ['encode' => 1, 'encodeSpaces' => 2];
        $attributes = [
            'encode' => true,
            'encodeSpaces' => false,
        ];
        $this->assertSameWithoutLE($expected, Html::renderSelectOptions(null, $data, $attributes));
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

    public function testBooleanAttributes(): void
    {
        $this->assertSame('<input type="email" name="mail">', Html::input('email', 'mail', null, ['required' => false]));
        $this->assertSame('<input type="email" name="mail" required>', Html::input('email', 'mail', null, ['required' => true]));
        $this->assertSame('<input type="email" name="mail" required="hi">', Html::input('email', 'mail', null, ['required' => 'hi']));
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
