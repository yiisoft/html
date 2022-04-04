<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Form;
use Yiisoft\Html\Tag\Input;

final class FormTest extends TestCase
{
    public function testBase(): void
    {
        $tag = Form::tag();

        $this->assertSame(
            '<form action="https://example.com/send" method="GET">' .
            '<input type="text" name="query">' .
            '<button type="submit">go</button>' .
            '</form>',
            $tag
                ->method('GET')
                ->action('https://example.com/send')
                ->content(
                    Input::text('query'),
                    Button::submit('go')
                )
                ->render()
        );
    }

    public function testGet(): void
    {
        $this->assertSame(
            '<form action="https://example.com/send" method="GET"></form>',
            Form::tag()->get('https://example.com/send')->render()
        );
    }

    public function testGetWithoutUrl(): void
    {
        $this->assertSame(
            '<form method="GET"></form>',
            Form::tag()->get()->render()
        );
    }

    public function testPost(): void
    {
        $this->assertSame(
            '<form action="https://example.com/send" method="POST"></form>',
            Form::tag()->post('https://example.com/send')->render()
        );
    }

    public function testPostWithoutUrl(): void
    {
        $this->assertSame(
            '<form method="POST"></form>',
            Form::tag()->post()->render()
        );
    }

    public function dataAcceptCharset(): array
    {
        return [
            ['<form></form>', null],
            ['<form accept-charset="windows-1251"></form>', 'windows-1251'],
        ];
    }

    /**
     * @dataProvider dataAcceptCharset
     */
    public function testAcceptCharset(string $expected, ?string $charset): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->acceptCharset($charset)->render()
        );
    }

    public function dataAction(): array
    {
        return [
            ['<form></form>', null],
            ['<form action="https://example.com/send"></form>', 'https://example.com/send'],
        ];
    }

    /**
     * @dataProvider dataAction
     */
    public function testAction(string $expected, ?string $action): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->action($action)->render()
        );
    }

    public function dataAutocomplete(): array
    {
        return [
            ['<form autocomplete="on"></form>', true],
            ['<form autocomplete="off"></form>', false],
        ];
    }

    /**
     * @dataProvider dataAutocomplete
     */
    public function testAutocomplete(string $expected, bool $value): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->autocomplete($value)->render()
        );
    }

    public function testDefaultAutocomplete(): void
    {
        $this->assertSame(
            '<form autocomplete="on"></form>',
            Form::tag()->autocomplete()->render()
        );
    }

    public function dataEnctype(): array
    {
        return [
            ['<form></form>', null],
            ['<form enctype="application/x-www-form-urlencoded"></form>', 'application/x-www-form-urlencoded'],
        ];
    }

    /**
     * @dataProvider dataEnctype
     */
    public function testEnctype(string $expected, ?string $enctype): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->enctype($enctype)->render()
        );
    }

    public function dataMethod(): array
    {
        return [
            ['<form></form>', null],
            ['<form method="get"></form>', 'get'],
        ];
    }

    /**
     * @dataProvider dataMethod
     */
    public function testMethod(string $expected, ?string $method): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->method($method)->render()
        );
    }

    public function dataNoValidate(): array
    {
        return [
            ['<form></form>', false],
            ['<form novalidate></form>', true],
        ];
    }

    /**
     * @dataProvider dataNoValidate
     */
    public function testNoValidate(string $expected, bool $noValidate): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->noValidate($noValidate)->render()
        );
    }

    public function testDefaultNoValidate(): void
    {
        $this->assertSame(
            '<form novalidate></form>',
            Form::tag()->noValidate()->render()
        );
    }

    public function dataTarget(): array
    {
        return [
            ['<form></form>', null],
            ['<form target="_blank"></form>', '_blank'],
        ];
    }

    /**
     * @dataProvider dataTarget
     */
    public function testTarget(string $expected, ?string $target): void
    {
        $this->assertSame(
            $expected,
            Form::tag()->target($target)->render()
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
        $this->assertNotSame($tag, $tag->method(null));
        $this->assertNotSame($tag, $tag->noValidate());
        $this->assertNotSame($tag, $tag->target(null));
    }
}
