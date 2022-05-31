<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;

final class ButtonTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<button type="submit">Send</button>',
            (string)Button::tag()
                ->type('submit')
                ->content('Send')
        );
    }

    public function testButton(): void
    {
        $this->assertSame(
            '<button type="button">Agree</button>',
            (string)Button::button('Agree')
        );
    }

    public function testSubmit(): void
    {
        $this->assertSame(
            '<button type="submit">Send</button>',
            (string)Button::submit('Send')
        );
    }

    public function testReset(): void
    {
        $this->assertSame(
            '<button type="reset">Reset form</button>',
            (string)Button::reset('Reset form')
        );
    }

    public function dataType(): array
    {
        return [
            ['<button></button>', null],
            ['<button type="submit"></button>', 'submit'],
        ];
    }

    /**
     * @dataProvider dataType
     */
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string)Button::tag()->type($type));
    }

    public function testDisabled(): void
    {
        $this->assertSame('<button disabled></button>', (string)Button::tag()->disabled());
        $this->assertSame('<button></button>', (string)Button::tag()->disabled(false));
        $this->assertSame('<button></button>', (string)Button::tag()
            ->disabled(true)
            ->disabled(false));
    }

    public function testImmutability(): void
    {
        $button = Button::tag();
        $this->assertNotSame($button, $button->type(null));
        $this->assertNotSame($button, $button->disabled());
    }
}
