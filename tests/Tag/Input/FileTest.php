<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input\File;

final class FileTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<input type="file" name="avatar">',
            new File()
                ->name('avatar')
                ->render(),
        );
    }

    public static function dataUncheckValue(): array
    {
        return [
            ['<input type="file">', null, null],
            ['<input type="file">', null, 7],
            ['<input type="file" name="avatar">', 'avatar', null],
            ['<input type="file" name="avatar[]">', 'avatar[]', null],
            [
                '<input type="hidden" name="avatar" value="7"><input type="file" name="avatar">',
                'avatar',
                7,
            ],
            [
                '<input type="hidden" name="avatar" value="7"><input type="file" name="avatar[]">',
                'avatar[]',
                7,
            ],
        ];
    }

    #[DataProvider('dataUncheckValue')]
    public function testUncheckValue(string $expected, ?string $name, $value): void
    {
        $this->assertSame(
            $expected,
            new File()
                ->name($name)
                ->uncheckValue($value)
                ->render(),
        );
    }

    public function testUncheckValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" disabled>'
            . '<input type="file" name="avatar" disabled>',
            new File()
                ->name('avatar')
                ->uncheckValue(7)
                ->disabled()
                ->render(),
        );
    }

    public function testUncheckValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" form="post">'
            . '<input type="file" name="avatar" form="post">',
            new File()
                ->name('avatar')
                ->uncheckValue(7)
                ->form('post')
                ->render(),
        );
    }

    public function testUncheckInputAttributes(): void
    {
        $result = new File()
            ->name('avatar')
            ->uncheckValue(7)
            ->addUncheckInputAttributes(['id' => 'FileHidden'])
            ->addUncheckInputAttributes(['data-key' => '100'])
            ->form('post')
            ->render();

        $this->assertSame(
            '<input type="hidden" id="FileHidden" name="avatar" value="7" form="post" data-key="100">'
            . '<input type="file" name="avatar" form="post">',
            $result,
        );
    }

    public function testReplaceUncheckInputAttributes(): void
    {
        $result = new File()
            ->name('avatar')
            ->uncheckValue(7)
            ->addUncheckInputAttributes(['id' => 'FileHidden'])
            ->uncheckInputAttributes(['data-key' => '100'])
            ->form('post')
            ->render();

        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" form="post" data-key="100">'
            . '<input type="file" name="avatar" form="post">',
            $result,
        );
    }

    public static function dataAccept(): array
    {
        return [
            [
                '<input type="file" name="avatar">',
                null,
            ],
            [
                '<input type="file" name="avatar" accept=".doc,.docx">',
                '.doc,.docx',
            ],
        ];
    }

    #[DataProvider('dataAccept')]
    public function testAccept(string $expected, ?string $accept): void
    {
        $this->assertSame(
            $expected,
            new File()
                ->name('avatar')
                ->accept($accept)
                ->render(),
        );
    }

    public static function dataMultiple(): array
    {
        return [
            [
                '<input type="file" name="avatar" multiple>',
                true,
            ],
            [
                '<input type="file" name="avatar">',
                false,
            ],
        ];
    }

    #[DataProvider('dataMultiple')]
    public function testMultiple(string $expected, ?bool $multiple): void
    {
        $this->assertSame(
            $expected,
            new File()
                ->name('avatar')
                ->multiple($multiple)
                ->render(),
        );
    }

    public function testMultipleDefault(): void
    {
        $this->assertSame(
            '<input type="file" name="avatar" multiple>',
            new File()
                ->name('avatar')
                ->multiple()
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = new File();

        $this->assertNotSame($tag, $tag->uncheckValue(null));
        $this->assertNotSame($tag, $tag->addUncheckInputAttributes([]));
        $this->assertNotSame($tag, $tag->uncheckInputAttributes([]));
        $this->assertNotSame($tag, $tag->accept(null));
        $this->assertNotSame($tag, $tag->multiple());
    }
}
