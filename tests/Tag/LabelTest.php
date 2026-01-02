<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Label;

final class LabelTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<label for="name">Your name</label>',
            (string) Label::tag()
                ->forId('name')
                ->content('Your name'),
        );
    }

    public static function dataForId(): array
    {
        return [
            ['<label></label>', null],
            ['<label for="name"></label>', 'name'],
        ];
    }

    #[DataProvider('dataForId')]
    public function testForId(string $expected, ?string $id): void
    {
        $this->assertSame($expected, (string) Label::tag()->forId($id));
    }

    public function testImmutability(): void
    {
        $label = Label::tag();
        $this->assertNotSame($label, $label->forId(null));
    }
}
