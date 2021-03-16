<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;

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
        self::assertSame('<h1></h1>', Html::tag('h1')->render());
        self::assertSame('<h1>hello</h1>', Html::tag('h1', 'hello')->render());
        self::assertSame('<h1 id="main">hello</h1>', Html::tag('h1', 'hello', ['id' => 'main'])->render());
    }

    public function testNormalTag(): void
    {
        self::assertSame('<h1></h1>', Html::normalTag('h1')->render());
        self::assertSame('<col></col>', Html::normalTag('col')->render());
        self::assertSame('<h1>hello</h1>', Html::normalTag('h1', 'hello')->render());
        self::assertSame('<h1 id="main">hello</h1>', Html::normalTag('h1', 'hello', ['id' => 'main'])->render());
    }

    public function testVoidTag(): void
    {
        self::assertSame('<h1>', Html::voidTag('h1')->render());
        self::assertSame('<h1 id="main">', Html::voidTag('h1', ['id' => 'main'])->render());
    }

    public function testOpenTag(): void
    {
        self::assertSame('<div>', Html::openTag('div'));
        self::assertSame(
            '<span id="test" class="title">',
            Html::openTag('span', ['id' => 'test', 'class' => 'title'])
        );
    }

    public function testCloseTag(): void
    {
        self::assertSame('</div>', Html::closeTag('div'));
    }

    public function testStyle(): void
    {
        self::assertSame('<style></style>', Html::style()->render());
        self::assertSame('<style>.red{color:#f00}</style>', Html::style('.red{color:#f00}')->render());
        self::assertSame(
            '<style id="main">.red{color:#f00}</style>',
            Html::style('.red{color:#f00}', ['id' => 'main'])->render()
        );
    }

    public function testScript(): void
    {
        self::assertSame('<script></script>', Html::script()->render());
        self::assertSame('<script>alert(15)</script>', Html::script('alert(15)')->render());
        self::assertSame(
            '<script id="main">alert(15)</script>',
            Html::script('alert(15)', ['id' => 'main'])->render()
        );
    }

    public function testMeta(): void
    {
        self::assertSame('<meta>', Html::meta()->render());
        self::assertSame(
            '<meta id="main" name="keywords" content="yii">',
            Html::meta(['name' => 'keywords', 'content' => 'yii', 'id' => 'main'])->render()
        );
    }

    public function testLink(): void
    {
        self::assertSame('<link>', Html::link()->render());
        self::assertSame('<link href="">', Html::link('')->render());
        self::assertSame('<link href="main.css">', Html::link('main.css')->render());
        self::assertSame(
            '<link id="main" href="main.css">',
            Html::link('main.css', ['id' => 'main'])->render()
        );
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
        self::assertSame(
            '<link id="main" href="http://example.com" rel="stylesheet">',
            Html::cssFile('http://example.com', ['id' => 'main'])->render()
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
        self::assertSame(
            '<script id="main" src="http://example.com"></script>',
            Html::javaScriptFile('http://example.com', ['id' => 'main'])->render()
        );
    }

    public function testA(): void
    {
        self::assertSame('<a></a>', Html::a()->render());
        self::assertSame('<a>link</a>', Html::a('link')->render());
        self::assertSame('<a href="https://example.com">link</a>', Html::a('link', 'https://example.com')->render());
        self::assertSame(
            '<a id="home" href="https://example.com">link</a>',
            Html::a('link', 'https://example.com', ['id' => 'home'])->render()
        );
    }

    public function testMailto(): void
    {
        self::assertSame(
            '<a href="mailto:info@example.com">info@example.com</a>',
            Html::mailto('info@example.com')->render()
        );
        self::assertSame(
            '<a href="mailto:info@example.com">contact me</a>',
            Html::mailto('contact me', 'info@example.com')->render()
        );
        self::assertSame(
            '<a id="contact" href="mailto:info@example.com">contact me</a>',
            Html::mailto('contact me', 'info@example.com', ['id' => 'contact'])->render()
        );
    }

    public function testImg(): void
    {
        self::assertSame('<img alt="">', Html::img()->render());
        self::assertSame('<img src="" alt="">', Html::img('')->render());
        self::assertSame('<img>', Html::img(null, null)->render());
        self::assertSame('<img src="face.png" alt="My Face">', Html::img('face.png', 'My Face')->render());
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
        self::assertSame(
            '<button type="button">Button</button>',
            Html::button('Button')->render()
        );
        self::assertSame(
            '<button type="button" id="main">Button</button>',
            Html::button('Button', ['id' => 'main'])->render()
        );
    }

    public function testSubmitButton(): void
    {
        self::assertSame(
            '<button type="submit">Submit</button>',
            Html::submitButton('Submit')->render()
        );
        self::assertSame(
            '<button type="submit" id="main">Submit</button>',
            Html::submitButton('Submit', ['id' => 'main'])->render()
        );
    }

    public function testResetButton(): void
    {
        self::assertSame(
            '<button type="reset">Reset</button>',
            Html::resetButton('Reset')->render()
        );
        self::assertSame(
            '<button type="reset" id="main">Reset</button>',
            Html::resetButton('Reset', ['id' => 'main'])->render()
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

    public function testRadio(): void
    {
        $this->assertSame('<input type="radio">', Html::radio()->render());
        $this->assertSame('<input type="radio" name="">', Html::radio('')->render());
        $this->assertSame('<input type="radio" value="">', Html::radio(null, '')->render());
        $this->assertSame('<input type="radio" name="test">', Html::radio('test')->render());
        $this->assertSame(
            '<input type="radio" name="test" value="43">',
            Html::radio('test', '43')->render(),
        );
    }

    public function testCheckbox(): void
    {
        $this->assertSame('<input type="checkbox">', Html::checkbox()->render());
        $this->assertSame('<input type="checkbox" name="">', Html::checkbox('')->render());
        $this->assertSame('<input type="checkbox" value="">', Html::checkbox(null, '')->render());
        $this->assertSame('<input type="checkbox" name="test">', Html::checkbox('test')->render());
        $this->assertSame(
            '<input type="checkbox" name="test" value="43">',
            Html::checkbox('test', '43')->render(),
        );
    }

    public function testSelect(): void
    {
        $this->assertSame('<select></select>', Html::select()->render());
        $this->assertSame('<select name=""></select>', Html::select('')->render());
        $this->assertSame('<select name="test"></select>', Html::select('test')->render());
    }

    public function testOptgroup(): void
    {
        self::assertSame('<optgroup></optgroup>', Html::optgroup()->render());
    }

    public function testOption(): void
    {
        self::assertSame('<option></option>', Html::option()->render());
        self::assertSame('<option value=""></option>', Html::option('', '')->render());
        self::assertSame('<option>test</option>', Html::option('test')->render());
        self::assertSame('<option value="42">test</option>', Html::option('test', 42)->render());
    }

    public function testTextarea(): void
    {
        $this->assertSame('<textarea></textarea>', Html::textarea()->render());
        $this->assertSame('<textarea name=""></textarea>', Html::textarea('')->render());
        $this->assertSame('<textarea name="test"></textarea>', Html::textarea('test')->render());
        $this->assertSame('<textarea name="test">body</textarea>', Html::textarea('test', 'body')->render());
    }

    public function testCheckboxList(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="0">' . "\n" .
            '<div id="main">' . "\n" .
            '<label><input type="checkbox" name="test[]" value="1"> One</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="2" checked> Two</label>' . "\n" .
            '<label><input type="checkbox" name="test[]" value="5" checked> Five</label>' . "\n" .
            '</div>',
            Html::checkboxList('test')
                ->items([1 => 'One', 2 => 'Two', 5 => 'Five'])
                ->uncheckValue(0)
                ->value(2, 5)
                ->containerAttributes(['id' => 'main'])
                ->render(),
        );
    }

    public function testRadioList(): void
    {
        self::assertSame(
            '<input type="hidden" name="test" value="0">' . "\n" .
            '<div id="main">' . "\n" .
            '<label><input type="radio" name="test" value="1"> One</label>' . "\n" .
            '<label><input type="radio" name="test" value="2" checked> Two</label>' . "\n" .
            '<label><input type="radio" name="test" value="5"> Five</label>' . "\n" .
            '</div>',
            Html::radioList('test')
                ->items([1 => 'One', 2 => 'Two', 5 => 'Five'])
                ->uncheckValue(0)
                ->value(2)
                ->containerAttributes(['id' => 'main'])
                ->render(),
        );
    }

    public function testDiv(): void
    {
        self::assertSame('<div></div>', Html::div()->render());
        self::assertSame('<div>hello</div>', Html::div('hello')->render());
        self::assertSame('<div id="main">hello</div>', Html::div('hello', ['id' => 'main'])->render());
    }

    public function testSpan(): void
    {
        self::assertSame('<span></span>', Html::span()->render());
        self::assertSame('<span>hello</span>', Html::span('hello')->render());
        self::assertSame('<span id="main">hello</span>', Html::span('hello', ['id' => 'main'])->render());
    }

    public function testP(): void
    {
        self::assertSame('<p></p>', Html::p()->render());
        self::assertSame('<p>hello</p>', Html::p('hello')->render());
        self::assertSame('<p id="main">hello</p>', Html::p('hello', ['id' => 'main'])->render());
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

    public function dataRenderTagAttributes(): array
    {
        return [
            ['', []],
            ['', ['id' => null]],
            [' id="main"', ['id' => 'main']],
            [' value="1&lt;&gt;"', ['value' => '1<>']],
            [
                ' checked disabled required="yes"',
                ['checked' => true, 'disabled' => true, 'hidden' => false, 'required' => 'yes'],
            ],
            [' class="first second"', ['class' => ['first', 'second']]],
            ['', ['class' => []]],
            [' style="width: 100px; height: 200px;"', ['style' => ['width' => '100px', 'height' => '200px']]],
            [' name="position" value="42"', ['value' => 42, 'name' => 'position']],
            [
                ' id="x" class="a b" data-a="1" data-b="2" style="width: 100px;" any=\'[1,2]\'',
                [
                    'id' => 'x',
                    'class' => ['a', 'b'],
                    'data' => ['a' => 1, 'b' => 2],
                    'style' => ['width' => '100px'],
                    'any' => [1, 2],
                ],
            ],
            [
                ' data-a="0" data-b=\'[1,2]\' any="42"',
                [
                    'class' => [],
                    'style' => [],
                    'data' => ['a' => 0, 'b' => [1, 2]],
                    'any' => 42,
                ],
            ],
            [
                ' data-foo=\'[]\'',
                [
                    'data' => [
                        'foo' => [],
                    ],
                ],
            ],
            [
                ' src="xyz" data-a="1" data-b="c"',
                ['src' => 'xyz', 'data' => ['a' => 1, 'b' => 'c']],
            ],
            [
                ' src="xyz" ng-a="1" ng-b="c"',
                ['src' => 'xyz', 'ng' => ['a' => 1, 'b' => 'c']],
            ],
            [
                ' src="xyz" data-ng-a="1" data-ng-b="c"',
                ['src' => 'xyz', 'data-ng' => ['a' => 1, 'b' => 'c']],
            ],
            [
                ' src="xyz" aria-a="1" aria-b="c"',
                ['src' => 'xyz', 'aria' => ['a' => 1, 'b' => 'c']],
            ],
            [
                ' src=\'{"a":1,"b":"It\\u0027s"}\'',
                ['src' => ['a' => 1, 'b' => "It's"]],
            ],
        ];
    }

    /**
     * @dataProvider dataRenderTagAttributes
     */
    public function testRenderTagAttributes(string $expected, array $attributes): void
    {
        self::assertSame($expected, Html::renderTagAttributes($attributes));
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
