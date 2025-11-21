<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Textarea;
use Yiisoft\Html\Tests\Objects\StringableObject;

final class TextareaTest extends TestCase
{
    public function testBase(): void
    {
        $textarea = Textarea::tag()
            ->name('body')
            ->value('content')
            ->rows(6);

        $this->assertSame('<textarea name="body" rows="6">content</textarea>', (string) $textarea);
    }

    public static function dataProviderName(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea name="body"></textarea>', 'body'],
        ];
    }

    #[DataProvider('dataProviderName')]
    public function testName(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string) Textarea::tag()->name($name));
    }

    public static function dataRows(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea rows="5"></textarea>', 5],
        ];
    }

    #[DataProvider('dataRows')]
    public function testRows(string $expected, ?int $rows): void
    {
        $this->assertSame($expected, (string) Textarea::tag()->rows($rows));
    }

    public static function dataColumns(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea cols="5"></textarea>', 5],
        ];
    }

    #[DataProvider('dataColumns')]
    public function testColumns(string $expected, ?int $columns): void
    {
        $this->assertSame($expected, (string) Textarea::tag()->columns($columns));
    }

    public static function dataValue(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea></textarea>', ''],
            ['<textarea></textarea>', new StringableObject('')],
            ['<textarea>content</textarea>', 'content'],
            ['<textarea>content</textarea>', new StringableObject('content')],
            [
                <<<HTML
                <textarea>a
                b

                c

                d</textarea>
                HTML,
                ['a', new StringableObject('b'), null, 'c', '', 'd'],
            ],
        ];
    }

    #[DataProvider('dataValue')]
    public function testValue(string $expected, mixed $value): void
    {
        $this->assertSame($expected, (string) Textarea::tag()->value($value));
    }

    public static function dataForm(): array
    {
        return [
            ['<textarea></textarea>', null],
            ['<textarea form></textarea>', ''],
            ['<textarea form="post"></textarea>', 'post'],
        ];
    }

    #[DataProvider('dataForm')]
    public function testForm(string $expected, ?string $formId): void
    {
        $this->assertSame($expected, Textarea::tag()
            ->form($formId)
            ->render());
    }

    public function testImmutability(): void
    {
        $textarea = Textarea::tag();
        $this->assertNotSame($textarea, $textarea->name(null));
        $this->assertNotSame($textarea, $textarea->rows(null));
        $this->assertNotSame($textarea, $textarea->columns(null));
        $this->assertNotSame($textarea, $textarea->value(null));
        $this->assertNotSame($textarea, $textarea->form(null));
    }
}
