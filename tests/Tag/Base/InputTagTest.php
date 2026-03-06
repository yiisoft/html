<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Base;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\StringableObject;
use Yiisoft\Html\Tests\Objects\TestInputTag;

final class InputTagTest extends TestCase
{
    public static function dataProviderName(): array
    {
        return [
            ['<input>', null],
            ['<input name="count">', 'count'],
        ];
    }

    #[DataProvider('dataProviderName')]
    public function testName(string $expected, ?string $name): void
    {
        $this->assertSame($expected, (string) (new TestInputTag())->name($name));
    }

    public static function dataValue(): array
    {
        return [
            'null' => ['<input>', null],
            'string' => ['<input value="hello">', 'hello'],
            'stringable' => ['<input value="string">', new StringableObject()],
            'int' => ['<input value="42">', 42],
            'float' => ['<input value="42.56">', 42.56],
            'float-zero' => ['<input value="42">', 42.00],
            'true' => ['<input value>', true],
            'false' => ['<input>', false],
        ];
    }

    #[DataProvider('dataValue')]
    public function testValue(string $expected, $value): void
    {
        $this->assertSame($expected, (string) (new TestInputTag())->value($value));
    }

    public static function dataForm(): array
    {
        return [
            ['<input>', null],
            ['<input form>', ''],
            ['<input form="post">', 'post'],
        ];
    }

    #[DataProvider('dataForm')]
    public function testForm(string $expected, ?string $formId): void
    {
        $this->assertSame($expected, new TestInputTag()
            ->form($formId)
            ->render());
    }

    public function testReadonly(): void
    {
        $this->assertSame('<input readonly>', (string) (new TestInputTag())->readonly());
        $this->assertSame('<input>', (string) (new TestInputTag())->readonly(false));
        $this->assertSame('<input>', (string) new TestInputTag()
            ->readonly(true)
            ->readonly(false));
    }

    public function testRequired(): void
    {
        $this->assertSame('<input required>', (string) (new TestInputTag())->required());
        $this->assertSame('<input>', (string) (new TestInputTag())->required(false));
        $this->assertSame('<input>', (string) new TestInputTag()
            ->required(true)
            ->required(false));
    }

    public function testDisabled(): void
    {
        $this->assertSame('<input disabled>', (string) (new TestInputTag())->disabled());
        $this->assertSame('<input>', (string) (new TestInputTag())->disabled(false));
        $this->assertSame('<input>', (string) new TestInputTag()
            ->disabled(true)
            ->disabled(false));
    }

    public function testImmutability(): void
    {
        $input = new TestInputTag();
        $this->assertNotSame($input, $input->name(null));
        $this->assertNotSame($input, $input->value(null));
        $this->assertNotSame($input, $input->form(null));
        $this->assertNotSame($input, $input->readonly());
        $this->assertNotSame($input, $input->required());
        $this->assertNotSame($input, $input->disabled());
    }
}
