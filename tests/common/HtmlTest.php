<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tests\Objects\StringableObject;

use function array_key_exists;

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
     */
    public function testEscapeJavaScriptStringValue(mixed $value, string $expected): void
    {
        $this->assertSame($expected, Html::escapeJavaScriptStringValue($value));
    }

    public function testTag(): void
    {
        $this->assertSame('<h1></h1>', Html::tag('h1')->render());
        $this->assertSame('<h1>hello</h1>', Html::tag('h1', 'hello')->render());
        $this->assertSame('<h1 id="main">hello</h1>', Html::tag('h1', 'hello', ['id' => 'main'])->render());
        $this->assertSame('<div><p>Hello</p></div>', Html::tag('div', Html::p('Hello'))->render());
    }

    public function testNormalTag(): void
    {
        $this->assertSame('<h1></h1>', Html::normalTag('h1')->render());
        $this->assertSame('<col></col>', Html::normalTag('col')->render());
        $this->assertSame('<h1>hello</h1>', Html::normalTag('h1', 'hello')->render());
        $this->assertSame('<h1 id="main">hello</h1>', Html::normalTag('h1', 'hello', ['id' => 'main'])->render());
        $this->assertSame('<div><p>Hello</p></div>', Html::normalTag('div', Html::p('Hello'))->render());
    }

    public function testVoidTag(): void
    {
        $this->assertSame('<h1>', Html::voidTag('h1')->render());
        $this->assertSame('<h1 id="main">', Html::voidTag('h1', ['id' => 'main'])->render());
    }

    public function testOpenTag(): void
    {
        $this->assertSame('<div>', Html::openTag('div'));
        $this->assertSame(
            '<span id="test" class="title">',
            Html::openTag('span', ['id' => 'test', 'class' => 'title'])
        );
    }

    public function testCloseTag(): void
    {
        $this->assertSame('</div>', Html::closeTag('div'));
    }

    public function testStyle(): void
    {
        $this->assertSame('<style></style>', Html::style()->render());
        $this->assertSame('<style>.red{color:#f00}</style>', Html::style('.red{color:#f00}')->render());
        $this->assertSame(
            '<style id="main">.red{color:#f00}</style>',
            Html::style('.red{color:#f00}', ['id' => 'main'])->render()
        );
    }

    public function testScript(): void
    {
        $this->assertSame('<script></script>', Html::script()->render());
        $this->assertSame('<script>alert(15)</script>', Html::script('alert(15)')->render());
        $this->assertSame(
            '<script id="main">alert(15)</script>',
            Html::script('alert(15)', ['id' => 'main'])->render()
        );
    }

    public function testNoscript(): void
    {
        $this->assertSame('<noscript></noscript>', Html::noscript()->render());
        $this->assertSame('<noscript>hello</noscript>', Html::noscript('hello')->render());
        $this->assertSame('<noscript><div></div></noscript>', Html::noscript(Div::tag())->render());
    }

    public function testTitle(): void
    {
        $this->assertSame('<title></title>', Html::title()->render());
        $this->assertSame('<title>hello</title>', Html::title('hello')->render());
        $this->assertSame('<title id="main">hello</title>', Html::title('hello', ['id' => 'main'])->render());
        $this->assertSame('<title>hello</title>', Html::title(new StringableObject('hello'))->render());
    }

    public function testMeta(): void
    {
        $this->assertSame('<meta>', Html::meta()->render());
        $this->assertSame(
            '<meta id="main" name="keywords" content="yii">',
            Html::meta(['name' => 'keywords', 'content' => 'yii', 'id' => 'main'])->render()
        );
    }

    public function testLink(): void
    {
        $this->assertSame('<link>', Html::link()->render());
        $this->assertSame('<link href>', Html::link('')->render());
        $this->assertSame('<link href="main.css">', Html::link('main.css')->render());
        $this->assertSame(
            '<link id="main" href="main.css">',
            Html::link('main.css', ['id' => 'main'])->render()
        );
    }

    public function testCssFile(): void
    {
        $this->assertSame(
            '<link href="http://example.com" rel="stylesheet">',
            Html::cssFile('http://example.com')->render()
        );
        $this->assertSame(
            '<link href rel="stylesheet">',
            Html::cssFile('')->render()
        );
        $this->assertSame(
            '<link id="main" href="http://example.com" rel="stylesheet">',
            Html::cssFile('http://example.com', ['id' => 'main'])->render()
        );
    }

    public function testJavaScriptFile(): void
    {
        $this->assertSame(
            '<script src="http://example.com"></script>',
            Html::javaScriptFile('http://example.com')->render()
        );
        $this->assertSame(
            '<script src></script>',
            Html::javaScriptFile('')->render()
        );
        $this->assertSame(
            '<script id="main" src="http://example.com"></script>',
            Html::javaScriptFile('http://example.com', ['id' => 'main'])->render()
        );
    }

    public function testA(): void
    {
        $this->assertSame('<a></a>', Html::a()->render());
        $this->assertSame('<a>link</a>', Html::a('link')->render());
        $this->assertSame('<a href="https://example.com">link</a>', Html::a('link', 'https://example.com')->render());
        $this->assertSame(
            '<a id="home" href="https://example.com">link</a>',
            Html::a('link', 'https://example.com', ['id' => 'home'])->render()
        );
        $this->assertSame('<a><span>Hello</span></a>', Html::a(Html::span('Hello'))->render());
    }

    public function testMailto(): void
    {
        $this->assertSame(
            '<a href="mailto:info@example.com">info@example.com</a>',
            Html::mailto('info@example.com')->render()
        );
        $this->assertSame(
            '<a href="mailto:info@example.com">contact me</a>',
            Html::mailto('contact me', 'info@example.com')->render()
        );
        $this->assertSame(
            '<a id="contact" href="mailto:info@example.com">contact me</a>',
            Html::mailto('contact me', 'info@example.com', ['id' => 'contact'])->render()
        );
    }

    public function testImg(): void
    {
        $this->assertSame('<img alt>', Html::img()->render());
        $this->assertSame('<img src alt>', Html::img('')->render());
        $this->assertSame('<img>', Html::img(null, null)->render());
        $this->assertSame('<img src="face.png" alt="My Face">', Html::img('face.png', 'My Face')->render());
        $this->assertSame('<img id="picture" src="face.png" alt="My Face">', Html::img('face.png', 'My Face', ['id' => 'picture'])->render());
    }

    public function testFieldset(): void
    {
        $this->assertSame(
            '<fieldset></fieldset>',
            Html::fieldset()->render()
        );
        $this->assertSame(
            '<fieldset id="MyFields"></fieldset>',
            Html::fieldset(['id' => 'MyFields'])->render()
        );
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<form></form>',
            Html::form()->render()
        );
        $this->assertSame(
            '<form action="https://example.com/send"></form>',
            Html::form('https://example.com/send')->render()
        );
        $this->assertSame(
            '<form action="https://example.com/send" method="GET"></form>',
            Html::form('https://example.com/send', 'GET')->render()
        );
        $this->assertSame(
            '<form class="red-form" action="https://example.com/send" method="GET"></form>',
            Html::form('https://example.com/send', 'GET', ['class' => 'red-form'])->render()
        );
    }

    public function testLabel(): void
    {
        $this->assertSame('<label></label>', Html::label()->render());
        $this->assertSame('<label>Name</label>', Html::label('Name')->render());
        $this->assertSame('<label for>Name</label>', Html::label('Name', '')->render());
        $this->assertSame('<label for="fieldName">Name</label>', Html::label('Name', 'fieldName')->render());
        $this->assertSame('<label><span>Hello</span></label>', Html::label(Html::span('Hello'))->render());
    }

    public function testLegend(): void
    {
        $this->assertSame(
            '<legend></legend>',
            Html::legend()->render()
        );
        $this->assertSame(
            '<legend>Your data</legend>',
            Html::legend('Your data')->render()
        );
        $this->assertSame(
            '<legend id="MyLegend">Your data</legend>',
            Html::legend('Your data', ['id' => 'MyLegend'])->render()
        );
    }

    public function testButton(): void
    {
        $this->assertSame(
            '<button type="button">Button</button>',
            Html::button('Button')->render()
        );
        $this->assertSame(
            '<button type="button" id="main">Button</button>',
            Html::button('Button', ['id' => 'main'])->render()
        );
    }

    public function testSubmitButton(): void
    {
        $this->assertSame(
            '<button type="submit">Submit</button>',
            Html::submitButton('Submit')->render()
        );
        $this->assertSame(
            '<button type="submit" id="main">Submit</button>',
            Html::submitButton('Submit', ['id' => 'main'])->render()
        );
    }

    public function testResetButton(): void
    {
        $this->assertSame(
            '<button type="reset">Reset</button>',
            Html::resetButton('Reset')->render()
        );
        $this->assertSame(
            '<button type="reset" id="main">Reset</button>',
            Html::resetButton('Reset', ['id' => 'main'])->render()
        );
    }

    public function testInput(): void
    {
        $this->assertSame('<input type>', Html::input('')->render());
        $this->assertSame('<input type="text">', Html::input('text')->render());
        $this->assertSame('<input type="text" name>', Html::input('text', '')->render());
        $this->assertSame('<input type="text" value>', Html::input('text', null, '')->render());
        $this->assertSame('<input type="text" name="test">', Html::input('text', 'test')->render());
        $this->assertSame(
            '<input type="text" name="test" value="43">',
            Html::input('text', 'test', '43')->render(),
        );
        $this->assertSame(
            '<input type="text" name="test" value="43" data-key="x101">',
            Html::input('text', 'test', '43', ['data-key' => 'x101'])->render(),
        );
    }

    public function testButtonInput(): void
    {
        $this->assertSame('<input type="button" value="Button">', Html::buttonInput()->render());
        $this->assertSame('<input type="button">', Html::buttonInput(null)->render());
        $this->assertSame('<input type="button" value>', Html::buttonInput('')->render());
        $this->assertSame('<input type="button" value="Go">', Html::buttonInput('Go')->render());
        $this->assertSame(
            '<input type="button" value="Go" data-key="x101">',
            Html::buttonInput('Go', ['data-key' => 'x101'])->render(),
        );
    }

    public function testSubmitInput(): void
    {
        $this->assertSame('<input type="submit" value="Submit">', Html::submitInput()->render());
        $this->assertSame('<input type="submit">', Html::submitInput(null)->render());
        $this->assertSame('<input type="submit" value>', Html::submitInput('')->render());
        $this->assertSame('<input type="submit" value="Go">', Html::submitInput('Go')->render());
        $this->assertSame(
            '<input type="submit" value="Go" data-key="x101">',
            Html::submitInput('Go', ['data-key' => 'x101'])->render(),
        );
    }

    public function testResetInput(): void
    {
        $this->assertSame('<input type="reset" value="Reset">', Html::resetInput()->render());
        $this->assertSame('<input type="reset">', Html::resetInput(null)->render());
        $this->assertSame('<input type="reset" value>', Html::resetInput('')->render());
        $this->assertSame('<input type="reset" value="Go">', Html::resetInput('Go')->render());
        $this->assertSame(
            '<input type="reset" value="Go" data-key="x101">',
            Html::resetInput('Go', ['data-key' => 'x101'])->render(),
        );
    }

    public function testTextInput(): void
    {
        $this->assertSame('<input type="text">', Html::textInput()->render());
        $this->assertSame('<input type="text" name>', Html::textInput('')->render());
        $this->assertSame('<input type="text" value>', Html::textInput(null, '')->render());
        $this->assertSame('<input type="text" name="test">', Html::textInput('test')->render());
        $this->assertSame(
            '<input type="text" name="test" value="43">',
            Html::textInput('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="text" name="test" value="43" required>',
            Html::textInput('test', '43', ['required' => true])->render(),
        );
    }

    public function testHiddenInput(): void
    {
        $this->assertSame('<input type="hidden">', Html::hiddenInput()->render());
        $this->assertSame('<input type="hidden" name>', Html::hiddenInput('')->render());
        $this->assertSame('<input type="hidden" value>', Html::hiddenInput(null, '')->render());
        $this->assertSame('<input type="hidden" name="test">', Html::hiddenInput('test')->render());
        $this->assertSame(
            '<input type="hidden" name="test" value="43">',
            Html::hiddenInput('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="hidden" id="ABC" name="test" value="43">',
            Html::hiddenInput('test', '43', ['id' => 'ABC'])->render(),
        );
    }

    public function testPasswordInput(): void
    {
        $this->assertSame('<input type="password">', Html::passwordInput()->render());
        $this->assertSame('<input type="password" name>', Html::passwordInput('')->render());
        $this->assertSame('<input type="password" value>', Html::passwordInput(null, '')->render());
        $this->assertSame('<input type="password" name="test">', Html::passwordInput('test')->render());
        $this->assertSame(
            '<input type="password" name="test" value="43">',
            Html::passwordInput('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="password" name="test" value="43" data-key="7">',
            Html::passwordInput('test', '43', ['data-key' => '7'])->render(),
        );
    }

    public function testFile(): void
    {
        $this->assertSame('<input type="file">', Html::file()->render());
        $this->assertSame('<input type="file" name>', Html::file('')->render());
        $this->assertSame('<input type="file" value>', Html::file(null, '')->render());
        $this->assertSame('<input type="file" name="test">', Html::file('test')->render());
        $this->assertSame(
            '<input type="file" name="test" value="43">',
            Html::file('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="file" class="photo" name="test" value="43">',
            Html::file('test', '43', ['class' => 'photo'])->render(),
        );
    }

    public function testRadio(): void
    {
        $this->assertSame('<input type="radio">', Html::radio()->render());
        $this->assertSame('<input type="radio" name>', Html::radio('')->render());
        $this->assertSame('<input type="radio" value>', Html::radio(null, '')->render());
        $this->assertSame('<input type="radio" name="test">', Html::radio('test')->render());
        $this->assertSame(
            '<input type="radio" name="test" value="43">',
            Html::radio('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="radio" name="test" value="43" readonly>',
            Html::radio('test', '43', ['readonly' => true])->render(),
        );
    }

    public function testCheckbox(): void
    {
        $this->assertSame('<input type="checkbox">', Html::checkbox()->render());
        $this->assertSame('<input type="checkbox" name>', Html::checkbox('')->render());
        $this->assertSame('<input type="checkbox" value>', Html::checkbox(null, '')->render());
        $this->assertSame('<input type="checkbox" name="test">', Html::checkbox('test')->render());
        $this->assertSame(
            '<input type="checkbox" name="test" value="43">',
            Html::checkbox('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="checkbox" name="test" value="43" readonly>',
            Html::checkbox('test', '43', ['readonly' => true])->render(),
        );
    }

    public function testRange(): void
    {
        $this->assertSame('<input type="range">', Html::range()->render());
        $this->assertSame('<input type="range" name>', Html::range('')->render());
        $this->assertSame('<input type="range" value>', Html::range(null, '')->render());
        $this->assertSame('<input type="range" name="test">', Html::range('test')->render());
        $this->assertSame(
            '<input type="range" name="test" value="43">',
            Html::range('test', '43')->render(),
        );
        $this->assertSame(
            '<input type="range" name="test" value="43" readonly>',
            Html::range('test', '43', ['readonly' => true])->render(),
        );
    }

    public function testSelect(): void
    {
        $this->assertSame('<select></select>', Html::select()->render());
        $this->assertSame('<select name></select>', Html::select('')->render());
        $this->assertSame('<select name="test"></select>', Html::select('test')->render());
    }

    public function testOptgroup(): void
    {
        $this->assertSame('<optgroup></optgroup>', Html::optgroup()->render());
    }

    public function testOption(): void
    {
        $this->assertSame('<option></option>', Html::option()->render());
        $this->assertSame('<option value></option>', Html::option('', '')->render());
        $this->assertSame('<option>test</option>', Html::option('test')->render());
        $this->assertSame('<option value="42">test</option>', Html::option('test', 42)->render());
        $this->assertSame('<option><span>Hello</span></option>', Html::option(Html::span('Hello'))->render());
    }

    public function testTextarea(): void
    {
        $this->assertSame('<textarea></textarea>', Html::textarea()->render());
        $this->assertSame('<textarea name></textarea>', Html::textarea('')->render());
        $this->assertSame('<textarea name="test"></textarea>', Html::textarea('test')->render());
        $this->assertSame('<textarea name="test">body</textarea>', Html::textarea('test', 'body')->render());
        $this->assertSame(
            '<textarea name="test" readonly>body</textarea>',
            Html::textarea('test', 'body', ['readonly' => true])->render()
        );
    }

    public function testCheckboxList(): void
    {
        $this->assertSame(
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
        $this->assertSame(
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
        $this->assertSame('<div></div>', Html::div()->render());
        $this->assertSame('<div>hello</div>', Html::div('hello')->render());
        $this->assertSame('<div id="main">hello</div>', Html::div('hello', ['id' => 'main'])->render());
        $this->assertSame('<div><span>Hello</span></div>', Html::div(Html::span('Hello'))->render());
    }

    public function testSpan(): void
    {
        $this->assertSame('<span></span>', Html::span()->render());
        $this->assertSame('<span>hello</span>', Html::span('hello')->render());
        $this->assertSame('<span id="main">hello</span>', Html::span('hello', ['id' => 'main'])->render());
        $this->assertSame('<span><span>Hello</span></span>', Html::span(Html::span('Hello'))->render());
    }

    public function testEm(): void
    {
        $this->assertSame('<em></em>', Html::em()->render());
        $this->assertSame('<em>hello</em>', Html::em('hello')->render());
        $this->assertSame('<em id="main">hello</em>', Html::em('hello', ['id' => 'main'])->render());
        $this->assertSame('<em><span>Hello</span></em>', Html::em(Html::span('Hello'))->render());
    }

    public function testStrong(): void
    {
        $this->assertSame('<strong></strong>', Html::strong()->render());
        $this->assertSame('<strong>hello</strong>', Html::strong('hello')->render());
        $this->assertSame('<strong id="main">hello</strong>', Html::strong('hello', ['id' => 'main'])->render());
        $this->assertSame('<strong><span>Hello</span></strong>', Html::strong(Html::span('Hello'))->render());
    }

    public function testSmall(): void
    {
        $this->assertSame('<small></small>', Html::small()->render());
        $this->assertSame('<small>hello</small>', Html::small('hello')->render());
        $this->assertSame('<small id="main">hello</small>', Html::small('hello', ['id' => 'main'])->render());
        $this->assertSame('<small><span>Hello</span></small>', Html::small(Html::span('Hello'))->render());
    }

    public function testB(): void
    {
        $this->assertSame('<b></b>', Html::b()->render());
        $this->assertSame('<b>hello</b>', Html::b('hello')->render());
        $this->assertSame('<b id="main">hello</b>', Html::b('hello', ['id' => 'main'])->render());
        $this->assertSame('<b><span>Hello</span></b>', Html::b(Html::span('Hello'))->render());
    }

    public function testI(): void
    {
        $this->assertSame('<i></i>', Html::i()->render());
        $this->assertSame('<i>hello</i>', Html::i('hello')->render());
        $this->assertSame('<i id="main">hello</i>', Html::i('hello', ['id' => 'main'])->render());
        $this->assertSame('<i><span>Hello</span></i>', Html::i(Html::span('Hello'))->render());
    }

    public function testH1(): void
    {
        $this->assertSame('<h1></h1>', Html::h1()->render());
        $this->assertSame('<h1>hello</h1>', Html::h1('hello')->render());
        $this->assertSame('<h1 id="main">hello</h1>', Html::h1('hello', ['id' => 'main'])->render());
        $this->assertSame('<h1><span>Hello</span></h1>', Html::h1(Html::span('Hello'))->render());
    }

    public function testH2(): void
    {
        $this->assertSame('<h2></h2>', Html::h2()->render());
        $this->assertSame('<h2>hello</h2>', Html::h2('hello')->render());
        $this->assertSame('<h2 id="main">hello</h2>', Html::h2('hello', ['id' => 'main'])->render());
        $this->assertSame('<h2><span>Hello</span></h2>', Html::h2(Html::span('Hello'))->render());
    }

    public function testH3(): void
    {
        $this->assertSame('<h3></h3>', Html::h3()->render());
        $this->assertSame('<h3>hello</h3>', Html::h3('hello')->render());
        $this->assertSame('<h3 id="main">hello</h3>', Html::h3('hello', ['id' => 'main'])->render());
        $this->assertSame('<h3><span>Hello</span></h3>', Html::h3(Html::span('Hello'))->render());
    }

    public function testH4(): void
    {
        $this->assertSame('<h4></h4>', Html::h4()->render());
        $this->assertSame('<h4>hello</h4>', Html::h4('hello')->render());
        $this->assertSame('<h4 id="main">hello</h4>', Html::h4('hello', ['id' => 'main'])->render());
        $this->assertSame('<h4><span>Hello</span></h4>', Html::h4(Html::span('Hello'))->render());
    }

    public function testH5(): void
    {
        $this->assertSame('<h5></h5>', Html::h5()->render());
        $this->assertSame('<h5>hello</h5>', Html::h5('hello')->render());
        $this->assertSame('<h5 id="main">hello</h5>', Html::h5('hello', ['id' => 'main'])->render());
        $this->assertSame('<h5><span>Hello</span></h5>', Html::h5(Html::span('Hello'))->render());
    }

    public function testH6(): void
    {
        $this->assertSame('<h6></h6>', Html::h6()->render());
        $this->assertSame('<h6>hello</h6>', Html::h6('hello')->render());
        $this->assertSame('<h6 id="main">hello</h6>', Html::h6('hello', ['id' => 'main'])->render());
        $this->assertSame('<h6><span>Hello</span></h6>', Html::h6(Html::span('Hello'))->render());
    }

    public function testP(): void
    {
        $this->assertSame('<p></p>', Html::p()->render());
        $this->assertSame('<p>hello</p>', Html::p('hello')->render());
        $this->assertSame('<p id="main">hello</p>', Html::p('hello', ['id' => 'main'])->render());
        $this->assertSame('<p><span>Hello</span></p>', Html::p(Html::span('Hello'))->render());
    }

    public function testUl(): void
    {
        $this->assertSame('<ul></ul>', Html::ul()->render());
        $this->assertSame('<ul id="main"></ul>', Html::ul(['id' => 'main'])->render());
        $this->assertSame(
            "<ul id=\"main\">\n<li>item 1</li>\n</ul>",
            Html::ul(['id' => 'main'])
                ->items(Html::li('item 1'))
                ->render()
        );
    }

    public function testOl(): void
    {
        $this->assertSame('<ol></ol>', Html::ol()->render());
        $this->assertSame('<ol id="main"></ol>', Html::ol(['id' => 'main'])->render());
        $this->assertSame(
            "<ol id=\"main\">\n<li>item 1</li>\n</ol>",
            Html::ol(['id' => 'main'])
                ->items(Html::li('item 1'))
                ->render()
        );
    }

    public function testLi(): void
    {
        $this->assertSame('<li></li>', Html::li()->render());
        $this->assertSame('<li>hello</li>', Html::li('hello')->render());
        $this->assertSame('<li><span>Hello</span></li>', Html::li(Html::span('Hello'))->render());
    }

    public function testDatalist(): void
    {
        $this->assertSame('<datalist></datalist>', Html::datalist()->render());
        $this->assertSame('<datalist id="numbers"></datalist>', Html::datalist(['id' => 'numbers'])->render());
    }

    public function testCaption(): void
    {
        $this->assertSame('<caption></caption>', Html::caption()->render());
        $this->assertSame('<caption>Hello</caption>', Html::caption('Hello')->render());
        $this->assertSame(
            '<caption class="red">Hello</caption>',
            Html::caption('Hello', ['class' => 'red'])->render()
        );
        $this->assertSame('<caption><span>Hello</span></caption>', Html::caption(Html::span('Hello'))->render());
    }

    public function testCol(): void
    {
        $this->assertSame('<col>', Html::col()->render());
        $this->assertSame('<col class="red">', Html::col(['class' => 'red'])->render());
    }

    public function testColgroup(): void
    {
        $this->assertSame('<colgroup></colgroup>', Html::colgroup()->render());
        $this->assertSame('<colgroup class="red"></colgroup>', Html::colgroup(['class' => 'red'])->render());
    }

    public function testTable(): void
    {
        $this->assertSame('<table></table>', Html::table()->render());
        $this->assertSame('<table class="red"></table>', Html::table(['class' => 'red'])->render());
    }

    public function testThead(): void
    {
        $this->assertSame('<thead></thead>', Html::thead()->render());
        $this->assertSame('<thead class="red"></thead>', Html::thead(['class' => 'red'])->render());
    }

    public function testTbody(): void
    {
        $this->assertSame('<tbody></tbody>', Html::tbody()->render());
        $this->assertSame('<tbody class="red"></tbody>', Html::tbody(['class' => 'red'])->render());
    }

    public function testTfoot(): void
    {
        $this->assertSame('<tfoot></tfoot>', Html::tfoot()->render());
        $this->assertSame('<tfoot class="red"></tfoot>', Html::tfoot(['class' => 'red'])->render());
    }

    public function testTr(): void
    {
        $this->assertSame('<tr></tr>', Html::tr()->render());
        $this->assertSame('<tr class="red"></tr>', Html::tr(['class' => 'red'])->render());
    }

    public function testTd(): void
    {
        $this->assertSame('<td></td>', Html::td()->render());
        $this->assertSame('<td>Hello</td>', Html::td('Hello')->render());
        $this->assertSame('<td class="red">Hello</td>', Html::td('Hello', ['class' => 'red'])->render());
        $this->assertSame('<td><span>Hello</span></td>', Html::td(Html::span('Hello'))->render());
    }

    public function testTh(): void
    {
        $this->assertSame('<th></th>', Html::th()->render());
        $this->assertSame('<th>Hello</th>', Html::th('Hello')->render());
        $this->assertSame('<th class="red">Hello</th>', Html::th('Hello', ['class' => 'red'])->render());
        $this->assertSame('<th><span>Hello</span></th>', Html::th(Html::span('Hello'))->render());
    }

    public function testBr(): void
    {
        self::assertSame('<br>', Html::br()->render());
    }

    public function testVideo(): void
    {
        $this->assertSame('<video></video>', Html::video()->render());
    }

    public function testAudio(): void
    {
        $this->assertSame('<audio></audio>', Html::audio()->render());
    }

    public function testTrack(): void
    {
        $this->assertSame('<track>', Html::track()->render());
        $this->assertSame('<track src="hi.png">', Html::track('hi.png')->render());
    }

    public function testPicture(): void
    {
        $this->assertSame('<picture></picture>', Html::picture()->render());
    }

    public function testSource(): void
    {
        $this->assertSame('<source>', Html::source()->render());
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
        $this->assertSame($expected, Html::renderTagAttributes($attributes));
    }

    public function dataAddCssClass(): array
    {
        return [
            0 => [['class' => 'test'], [], 'test'],
            1 => [['class' => 'test'], ['class' => 'test'], 'test'],
            2 => [['class' => 'test test2'], ['class' => 'test'], 'test2'],
            3 => [['class' => 'test test2'], ['class' => 'test test2'], 'test'],
            4 => [['class' => 'test test2'], ['class' => 'test test2'], 'test2'],
            5 => [['class' => 'test test2 test3'], ['class' => 'test test2'], 'test3'],
            6 => [['class' => 'test test2 test3'], ['class' => 'test test2 test3'], 'test2'],
            7 => [['class' => ['test', 'test2']], ['class' => ['test']], 'test2'],
            8 => [['class' => ['test', 'test2']], ['class' => ['test', 'test2']], 'test2'],
            9 => [['class' => ['test', 'test2', 'test3']], ['class' => ['test', 'test2']], ['test3']],
            10 => [['class' => 'test test2'], ['class' => 'test test'], 'test2'],
            11 => [['class' => 'test test2'], ['class' => 'test test2'], null],
            12 => [['class' => 'test test2'], ['class' => 'test test2'], [null]],
            13 => [['class' => ['t1', 't2', 't3', 't4']], ['class' => 't1 t2'], ['t3', null, 't4']],
            14 => [['id' => 'w2'], ['id' => 'w2'], null],
            15 => [['id' => 'w2'], ['id' => 'w2'], [null]],
            16 => [['id' => 'w2', 'class' => 't1'], ['id' => 'w2'], 't1'],
            17 => [['id' => 'w2', 'class' => ['t3', 2 => 't4']], ['id' => 'w2'], ['t3', null, 't4']],
        ];
    }

    /**
     * @dataProvider dataAddCssClass
     */
    public function testAddCssClass(array $expected, array $options, array|string|null $class): void
    {
        Html::addCssClass($options, $class);
        $this->assertSame($expected, $options);
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

    public function testAddCssClassArrayToString(): void
    {
        $options = ['class' => 'test'];

        Html::addCssClass($options, ['test1', 'test2']);

        $this->assertSame(
            [
                'class' => ['test', 'test1', 'test2'],
            ],
            $options,
        );
    }

    public function testAddCssClassWithKeyToString(): void
    {
        $options = ['class' => 'test_class'];

        Html::addCssClass($options, ['widget' => 'some_widget_class']);
        Html::addCssClass($options, ['widget' => 'some_other_widget_class_2']);

        $this->assertSame(
            [
                'class' => [
                    'test_class',
                    'widget' => 'some_widget_class',
                ],
            ],
            $options,
        );
    }

    public function testAddCssClassWithKeyToArray(): void
    {
        $options = ['class' => ['test_class']];

        Html::addCssClass($options, ['widget' => 'some_widget_class']);
        Html::addCssClass($options, ['widget' => 'some_other_widget_class_2']);

        $this->assertSame(
            [
                'class' => [
                    'test_class',
                    'widget' => 'some_widget_class',
                ],
            ],
            $options,
        );
    }

    public function testAddCssClassWithKeyToKeyArray(): void
    {
        $options = ['class' => ['widget' => 'test_class']];

        Html::addCssClass($options, ['widget' => 'some_widget_class']);
        Html::addCssClass($options, ['widget' => 'some_other_widget_class_2']);

        $this->assertSame(
            [
                'class' => [
                    'widget' => 'test_class',
                ],
            ],
            $options,
        );
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
     */
    public function testNormalizeRegexpPatternInvalid(string $regexp, ?string $delimiter = null): void
    {
        $this->expectException(InvalidArgumentException::class);
        Html::normalizeRegexpPattern($regexp, $delimiter);
    }

    public function testHtml(): void
    {
        $this->assertSame('<html></html>', Html::html()->render());
        $this->assertSame('<html>Welcome</html>', Html::html('Welcome')->render());
        $this->assertSame('<html lang="en">Welcome</html>', Html::html('Welcome', 'en')->render());
        $this->assertSame('<html id="main" lang="en">Welcome</html>', Html::html('Welcome', 'en', ['id' => 'main'])->render());
        $this->assertSame('<html><body>Welcome</body></html>', Html::html(Html::body('Welcome'))->render());
    }

    public function testBody(): void
    {
        $this->assertSame('<body></body>', Html::body()->render());
        $this->assertSame('<body>Welcome</body>', Html::body('Welcome')->render());
        $this->assertSame('<body id="main">Welcome</body>', Html::body('Welcome', ['id' => 'main'])->render());
        $this->assertSame('<body><h1>Welcome</h1></body>', Html::body(Html::h1('Welcome'))->render());
    }

    public function testArticle(): void
    {
        $this->assertSame('<article></article>', Html::article()->render());
        $this->assertSame(
            '<article>Body</article>',
            Html::article('Body')->render()
        );
        $this->assertSame(
            '<article class="red">Body</article>',
            Html::article('Body', ['class' => 'red'])->render()
        );
    }

    public function testSection(): void
    {
        $this->assertSame('<section></section>', Html::section()->render());
        $this->assertSame(
            '<section>Section Content</section>',
            Html::section('Section Content')->render()
        );
        $this->assertSame(
            '<section class="red">Section Content</section>',
            Html::section('Section Content', ['class' => 'red'])->render()
        );
    }

    public function testNav(): void
    {
        $this->assertSame('<nav></nav>', Html::nav()->render());
        $this->assertSame(
            '<nav>Navigation</nav>',
            Html::nav('Navigation')->render()
        );
        $this->assertSame(
            '<nav class="red">Navigation</nav>',
            Html::nav('Navigation', ['class' => 'red'])->render()
        );
    }

    public function testAside(): void
    {
        $this->assertSame('<aside></aside>', Html::aside()->render());
        $this->assertSame(
            '<aside>Hello</aside>',
            Html::aside('Hello')->render()
        );
        $this->assertSame(
            '<aside class="red">Hello</aside>',
            Html::aside('Hello', ['class' => 'red'])->render()
        );
    }

    public function testHgroup(): void
    {
        $this->assertSame('<hgroup></hgroup>', Html::hgroup()->render());
        $this->assertSame(
            '<hgroup>Headings</hgroup>',
            Html::hgroup('Headings')->render()
        );
        $this->assertSame(
            '<hgroup class="red">Headings</hgroup>',
            Html::hgroup('Headings', ['class' => 'red'])->render()
        );
    }

    public function testHeader(): void
    {
        $this->assertSame('<header></header>', Html::header()->render());
        $this->assertSame(
            '<header>The header.</header>',
            Html::header('The header.')->render()
        );
        $this->assertSame(
            '<header class="red">The header.</header>',
            Html::header('The header.', ['class' => 'red'])->render()
        );
    }

    public function testFooter(): void
    {
        $this->assertSame('<footer></footer>', Html::footer()->render());
        $this->assertSame(
            '<footer>The footer.</footer>',
            Html::footer('The footer.')->render()
        );
        $this->assertSame(
            '<footer class="red">The footer.</footer>',
            Html::footer('The footer.', ['class' => 'red'])->render()
        );
    }

    public function testAddress(): void
    {
        $this->assertSame('<address></address>', Html::address()->render());
        $this->assertSame(
            '<address>Street 111, Mount View Town.</address>',
            Html::address('Street 111, Mount View Town.')->render()
        );
        $this->assertSame(
            '<address class="red">Street 111, Mount View Town.</address>',
            Html::address('Street 111, Mount View Town.', ['class' => 'red'])->render()
        );
    }
}

namespace Yiisoft\Html;

use Yiisoft\Html\Tests\HtmlTest;

function hrtime(bool $getAsNumber = false)
{
    return HtmlTest::$hrtimeResult ?? \hrtime($getAsNumber);
}
