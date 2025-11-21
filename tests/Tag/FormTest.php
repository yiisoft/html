<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Form;
use Yiisoft\Html\Tag\Input;
use Yiisoft\Html\Tests\Objects\StringableObject;

final class FormTest extends TestCase
{
    public function testBase(): void
    {
        $tag = Form::tag();

        $this->assertSame(
            '<form action="https://example.com/send" method="GET">'
            . '<input type="text" name="query">'
            . '<button type="submit">go</button>'
            . '</form>',
            $tag
                ->method('GET')
                ->action('https://example.com/send')
                ->content(
                    Input::text('query'),
                    Button::submit('go'),
                )
                ->render(),
        );
    }

    public function testGet(): void
    {
        $this->assertSame(
            '<form action="https://example.com/send" method="GET"></form>',
            Form::tag()
                ->get('https://example.com/send')
                ->render(),
        );
    }

    public function testGetWithoutUrl(): void
    {
        $this->assertSame(
            '<form method="GET"></form>',
            Form::tag()
                ->get()
                ->render(),
        );
    }

    public function testPost(): void
    {
        $this->assertSame(
            '<form action="https://example.com/send" method="POST"></form>',
            Form::tag()
                ->post('https://example.com/send')
                ->render(),
        );
    }

    public function testPostWithoutUrl(): void
    {
        $this->assertSame(
            '<form method="POST"></form>',
            Form::tag()
                ->post()
                ->render(),
        );
    }

    public function testCsrf(): void
    {
        $tag = Form::tag()->csrf('abc', 'csrf-token');

        $this->assertSame(
            '<form>' . "\n"
            . '<input type="hidden" name="csrf-token" value="abc">',
            $tag->open(),
        );

        $this->assertSame(
            '<form>' . "\n"
            . '<input type="hidden" name="csrf-token" value="abc"></form>',
            $tag->render(),
        );
    }

    public function testCsrfDefaultName(): void
    {
        $this->assertSame(
            '<form>' . "\n"
            . '<input type="hidden" name="_csrf" value="abc"></form>',
            Form::tag()
                ->csrf('abc')
                ->render(),
        );
    }

    public function testStringableCsrfToken(): void
    {
        $this->assertSame(
            '<form>' . "\n"
            . '<input type="hidden" name="_csrf" value="abc"></form>',
            Form::tag()
                ->csrf(new StringableObject('abc'))
                ->render(),
        );
    }

    public static function dataAcceptCharset(): array
    {
        return [
            ['<form></form>', null],
            ['<form accept-charset="windows-1251"></form>', 'windows-1251'],
        ];
    }

    #[DataProvider('dataAcceptCharset')]
    public function testAcceptCharset(string $expected, ?string $charset): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->acceptCharset($charset)
                ->render(),
        );
    }

    public static function dataAction(): array
    {
        return [
            ['<form></form>', null],
            ['<form action="https://example.com/send"></form>', 'https://example.com/send'],
        ];
    }

    #[DataProvider('dataAction')]
    public function testAction(string $expected, ?string $action): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->action($action)
                ->render(),
        );
    }

    public static function dataAutocomplete(): array
    {
        return [
            ['<form autocomplete="on"></form>', true],
            ['<form autocomplete="off"></form>', false],
        ];
    }

    #[DataProvider('dataAutocomplete')]
    public function testAutocomplete(string $expected, bool $value): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->autocomplete($value)
                ->render(),
        );
    }

    public function testDefaultAutocomplete(): void
    {
        $this->assertSame(
            '<form autocomplete="on"></form>',
            Form::tag()
                ->autocomplete()
                ->render(),
        );
    }

    public static function dataEnctype(): array
    {
        return [
            ['<form></form>', null],
            ['<form enctype="application/x-www-form-urlencoded"></form>', 'application/x-www-form-urlencoded'],
        ];
    }

    #[DataProvider('dataEnctype')]
    public function testEnctype(string $expected, ?string $enctype): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->enctype($enctype)
                ->render(),
        );
    }

    public function testEnctypeApplicationXWwwFormUrlencoded(): void
    {
        $this->assertSame(
            '<form enctype="application/x-www-form-urlencoded"></form>',
            Form::tag()
                ->enctypeApplicationXWwwFormUrlencoded()
                ->render(),
        );
    }

    public function testEnctypeMultipartFormData(): void
    {
        $this->assertSame(
            '<form enctype="multipart/form-data"></form>',
            Form::tag()
                ->enctypeMultipartFormData()
                ->render(),
        );
    }

    public function testEnctypeTextPlain(): void
    {
        $this->assertSame(
            '<form enctype="text/plain"></form>',
            Form::tag()
                ->enctypeTextPlain()
                ->render(),
        );
    }

    public static function dataMethod(): array
    {
        return [
            ['<form></form>', null],
            ['<form method="get"></form>', 'get'],
        ];
    }

    #[DataProvider('dataMethod')]
    public function testMethod(string $expected, ?string $method): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->method($method)
                ->render(),
        );
    }

    public static function dataNoValidate(): array
    {
        return [
            ['<form></form>', false],
            ['<form novalidate></form>', true],
        ];
    }

    #[DataProvider('dataNoValidate')]
    public function testNoValidate(string $expected, bool $noValidate): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->noValidate($noValidate)
                ->render(),
        );
    }

    public function testDefaultNoValidate(): void
    {
        $this->assertSame(
            '<form novalidate></form>',
            Form::tag()
                ->noValidate()
                ->render(),
        );
    }

    public static function dataTarget(): array
    {
        return [
            ['<form></form>', null],
            ['<form target="_blank"></form>', '_blank'],
        ];
    }

    #[DataProvider('dataTarget')]
    public function testTarget(string $expected, ?string $target): void
    {
        $this->assertSame(
            $expected,
            Form::tag()
                ->target($target)
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = Form::tag();

        $this->assertNotSame($tag, $tag->get());
        $this->assertNotSame($tag, $tag->post());
        $this->assertNotSame($tag, $tag->acceptCharset(null));
        $this->assertNotSame($tag, $tag->action(null));
        $this->assertNotSame($tag, $tag->autocomplete());
        $this->assertNotSame($tag, $tag->enctype(null));
        $this->assertNotSame($tag, $tag->enctypeApplicationXWwwFormUrlencoded());
        $this->assertNotSame($tag, $tag->enctypeMultipartFormData());
        $this->assertNotSame($tag, $tag->enctypeTextPlain());
        $this->assertNotSame($tag, $tag->method(null));
        $this->assertNotSame($tag, $tag->noValidate());
        $this->assertNotSame($tag, $tag->target(null));
    }
}
