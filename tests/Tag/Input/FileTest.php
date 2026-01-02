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
            '<input name="avatar" type="file">',
            File::tag()
                ->name('avatar')
                ->render(),
        );
    }

    public static function dataUncheckValue(): array
    {
        return [
            ['<input type="file">', null, null],
            ['<input type="file">', null, 7],
            ['<input name="avatar" type="file">', 'avatar', null],
            ['<input name="avatar[]" type="file">', 'avatar[]', null],
            [
                '<input type="hidden" name="avatar" value="7"><input name="avatar" type="file">',
                'avatar',
                7,
            ],
            [
                '<input type="hidden" name="avatar" value="7"><input name="avatar[]" type="file">',
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
            File::tag()
                ->name($name)
                ->uncheckValue($value)
                ->render(),
        );
    }

    public function testUncheckValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" disabled>' .
            '<input name="avatar" disabled type="file">',
            File::tag()
                ->name('avatar')
                ->uncheckValue(7)
                ->disabled()
                ->render(),
        );
    }

    public function testUncheckValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" form="post">' .
            '<input name="avatar" form="post" type="file">',
            File::tag()
                ->name('avatar')
                ->uncheckValue(7)
                ->form('post')
                ->render(),
        );
    }

    public function testUncheckInputAttributes(): void
    {
        $result = File::tag()
            ->name('avatar')
            ->uncheckValue(7)
            ->addUncheckInputAttributes(['id' => 'FileHidden'])
            ->addUncheckInputAttributes(['data-key' => '100'])
            ->form('post')
            ->render();

        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" id="FileHidden" data-key="100" form="post">' .
            '<input name="avatar" form="post" type="file">',
            $result
        );
    }

    public function testReplaceUncheckInputAttributes(): void
    {
        $result = File::tag()
            ->name('avatar')
            ->uncheckValue(7)
            ->addUncheckInputAttributes(['id' => 'FileHidden'])
            ->uncheckInputAttributes(['data-key' => '100'])
            ->form('post')
            ->render();

        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" data-key="100" form="post">' .
            '<input name="avatar" form="post" type="file">',
            $result
        );
    }

    public static function dataAccept(): array
    {
        return [
            [
                '<input name="avatar" type="file">',
                null,
            ],
            [
                '<input name="avatar" accept=".doc,.docx" type="file">',
                '.doc,.docx',
            ],
        ];
    }

    #[DataProvider('dataAccept')]
    public function testAccept(string $expected, ?string $accept): void
    {
        $this->assertSame(
            $expected,
            File::tag()
                ->name('avatar')
                ->accept($accept)
                ->render(),
        );
    }

    public static function dataMultiple(): array
    {
        return [
            [
                '<input name="avatar" multiple type="file">',
                true,
            ],
            [
                '<input name="avatar" type="file">',
                false,
            ],
        ];
    }

    #[DataProvider('dataMultiple')]
    public function testMultiple(string $expected, ?bool $multiple): void
    {
        $this->assertSame(
            $expected,
            File::tag()
                ->name('avatar')
                ->multiple($multiple)
                ->render(),
        );
    }

    public function testMultipleDefault(): void
    {
        $this->assertSame(
            '<input name="avatar" multiple type="file">',
            File::tag()
                ->name('avatar')
                ->multiple()
                ->render(),
        );
    }

    public function testImmutability(): void
    {
        $tag = File::tag();

        $this->assertNotSame($tag, $tag->uncheckValue(null));
        $this->assertNotSame($tag, $tag->addUncheckInputAttributes([]));
        $this->assertNotSame($tag, $tag->uncheckInputAttributes([]));
        $this->assertNotSame($tag, $tag->accept(null));
        $this->assertNotSame($tag, $tag->multiple());
    }
}
