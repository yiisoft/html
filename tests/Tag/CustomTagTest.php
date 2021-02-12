<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\CustomTag;

final class CustomTagTest extends TestCase
{
    public function testBase(): void
    {
        self::assertSame(
            '<test id="custom" count="15">body</test>',
            CustomTag::name('test')->id('custom')->attribute('count', 15)->content('body')->render()
        );
    }

    public function dataVoidTags(): array
    {
        return [
            ['area'],
            ['AREA'],
            ['br'],
            ['hr'],
        ];
    }

    /**
     * @dataProvider dataVoidTags
     *
     * @psalm-param non-empty-string $name
     */
    public function testVoidTags(string $name): void
    {
        self::assertSame(
            "<$name>",
            CustomTag::name($name)->render()
        );
    }
}
