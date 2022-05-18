<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Input;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Input\File;

final class FileTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<input type="file" name="avatar">',
            File::tag()->name('avatar')->render()
        );
    }

    public function dataUncheckValue(): array
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

    /**
     * @dataProvider dataUncheckValue
     *
     * @param bool|float|int|string|\Stringable|null $value
     */
    public function testUncheckValue(string $expected, ?string $name, $value): void
    {
        $this->assertSame(
            $expected,
            File::tag()->name($name)->uncheckValue($value)->render()
        );
    }

    public function testUncheckValueDisabled(): void
    {
        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" disabled>' .
            '<input type="file" name="avatar" disabled>',
            File::tag()->name('avatar')->uncheckValue(7)->disabled()->render()
        );
    }

    public function testUncheckValueForm(): void
    {
        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" form="post">' .
            '<input type="file" name="avatar" form="post">',
            File::tag()->name('avatar')->uncheckValue(7)->form('post')->render()
        );
    }

    public function testUncheckInputAttributes(): void
    {
        $result = File::tag()
            ->name('avatar')
            ->uncheckValue(7)
            ->uncheckInputAttributes(['id' => 'FileHidden'])
            ->uncheckInputAttributes(['data-key' => '100'])
            ->form('post')
            ->render();

        $this->assertSame(
            '<input type="hidden" id="FileHidden" name="avatar" value="7" form="post" data-key="100">' .
            '<input type="file" name="avatar" form="post">',
            $result
        );
    }

    public function testReplaceUncheckInputAttributes(): void
    {
        $result = File::tag()
            ->name('avatar')
            ->uncheckValue(7)
            ->uncheckInputAttributes(['id' => 'FileHidden'])
            ->replaceUncheckInputAttributes(['data-key' => '100'])
            ->form('post')
            ->render();

        $this->assertSame(
            '<input type="hidden" name="avatar" value="7" form="post" data-key="100">' .
            '<input type="file" name="avatar" form="post">',
            $result
        );
    }

    public function dataAccept(): array
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

    /**
     * @dataProvider dataAccept
     */
    public function testAccept(string $expected, ?string $accept): void
    {
        $this->assertSame(
            $expected,
            File::tag()->name('avatar')->accept($accept)->render()
        );
    }

    public function dataMultiple(): array
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

    /**
     * @dataProvider dataMultiple
     */
    public function testMultiple(string $expected, ?bool $multiple): void
    {
        $this->assertSame(
            $expected,
            File::tag()->name('avatar')->multiple($multiple)->render()
        );
    }

    public function testMultipleDefault(): void
    {
        $this->assertSame(
            '<input type="file" name="avatar" multiple>',
            File::tag()->name('avatar')->multiple()->render()
        );
    }

    public function testImmutability(): void
    {
        $tag = File::tag();

        $this->assertNotSame($tag, $tag->uncheckValue(null));
        $this->assertNotSame($tag, $tag->uncheckInputAttributes([]));
        $this->assertNotSame($tag, $tag->replaceUncheckInputAttributes([]));
        $this->assertNotSame($tag, $tag->accept(null));
        $this->assertNotSame($tag, $tag->multiple());
    }
}
