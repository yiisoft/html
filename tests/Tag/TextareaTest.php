<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Textarea;

final class TextareaTest extends TestCase
{
    public function testBase(): void
    {
        $textarea = Textarea::tag()
            ->name('body')
            ->value('content')
            ->rows(6);

        self::assertSame('<textarea name="body" rows="6">content</textarea>', (string)$textarea);
    }

    public function dataName(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea name="body"></textarea>', 'body'],
        ];
    }

    /**
     * @dataProvider dataName
     */
    public function testName(string $expected, ?string $name): void
    {
        self::assertSame($expected, (string)Textarea::tag()->name($name));
    }

    public function dataRows(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea rows="5"></textarea>', 5],
        ];
    }

    /**
     * @dataProvider dataRows
     */
    public function testRows(string $expected, ?int $rows): void
    {
        self::assertSame($expected, (string)Textarea::tag()->rows($rows));
    }

    public function dataColumns(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea cols="5"></textarea>', 5],
        ];
    }

    /**
     * @dataProvider dataColumns
     */
    public function testColumns(string $expected, ?int $columns): void
    {
        self::assertSame($expected, (string)Textarea::tag()->columns($columns));
    }

    public function dataValue(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea>content</textarea>', 'content'],
        ];
    }

    /**
     * @dataProvider dataValue
     */
    public function testValue(string $expected, ?string $value): void
    {
        self::assertSame($expected, (string)Textarea::tag()->value($value));
    }

    public function dataForm(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea form=""></textarea>', ''],
            ['<textarea form="post"></textarea>', 'post'],
        ];
    }

    /**
     * @dataProvider dataForm
     */
    public function testForm(string $expected, ?string $formId): void
    {
        self::assertSame($expected, Textarea::tag()->form($formId)->render());
    }

    public function testImmutability(): void
    {
        $textarea = Textarea::tag();
        self::assertNotSame($textarea, $textarea->name(null));
        self::assertNotSame($textarea, $textarea->rows(null));
        self::assertNotSame($textarea, $textarea->columns(null));
        self::assertNotSame($textarea, $textarea->value(null));
        self::assertNotSame($textarea, $textarea->form(null));
    }
}
