<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Button;

final class ButtonTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<button type="submit">Send</button>',
            (string) (new Button())
                ->type('submit')
                ->content('Send'),
        );
    }

    public static function dataButton(): array
    {
        return [
            'string' => ['Agree', 'Agree'],
            'int' => ['42', 42],
            'float' => ['3.14', 3.14],
            'null' => ['', null],
        ];
    }

    #[DataProvider('dataButton')]
    public function testButton(string $expectedContent, string|int|float|null $content): void
    {
        $this->assertSame(
            "<button type=\"button\">$expectedContent</button>",
            (string) Button::button($content),
        );
    }

    public function testButtonWithoutContent(): void
    {
        $this->assertSame(
            '<button type="button"></button>',
            (string) Button::button(),
        );
    }

    public static function dataSubmit(): array
    {
        return [
            'string' => ['Send', 'Send'],
            'int' => ['1', 1],
            'float' => ['3.14', 3.14],
            'null' => ['', null],
        ];
    }

    #[DataProvider('dataSubmit')]
    public function testSubmit(string $expectedContent, string|int|float|null $content): void
    {
        $this->assertSame(
            "<button type=\"submit\">$expectedContent</button>",
            (string) Button::submit($content),
        );
    }

    public function testSubmitWithoutContent(): void
    {
        $this->assertSame(
            '<button type="submit"></button>',
            (string) Button::submit(),
        );
    }

    public static function dataReset(): array
    {
        return [
            'string' => ['Reset form', 'Reset form'],
            'int' => ['1', 1],
            'float' => ['3.14', 3.14],
            'null' => ['', null],
        ];
    }

    #[DataProvider('dataReset')]
    public function testReset(string $expectedContent, string|int|float|null $content): void
    {
        $this->assertSame(
            "<button type=\"reset\">$expectedContent</button>",
            (string) Button::reset($content),
        );
    }

    public function testResetWithoutContent(): void
    {
        $this->assertSame(
            '<button type="reset"></button>',
            (string) Button::reset(),
        );
    }

    public static function dataType(): array
    {
        return [
            ['<button></button>', null],
            ['<button type="submit"></button>', 'submit'],
        ];
    }

    #[DataProvider('dataType')]
    public function testType(string $expected, ?string $type): void
    {
        $this->assertSame($expected, (string) (new Button())->type($type));
    }

    public function testDisabled(): void
    {
        $this->assertSame('<button disabled></button>', (string) (new Button())->disabled());
        $this->assertSame('<button></button>', (string) (new Button())->disabled(false));
        $this->assertSame('<button></button>', (string) (new Button())
            ->disabled(true)
            ->disabled(false));
    }

    public function testImmutability(): void
    {
        $button = new Button();
        $this->assertNotSame($button, $button->type(null));
        $this->assertNotSame($button, $button->disabled());
    }
}
