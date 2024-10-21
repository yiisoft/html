<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Fieldset;
use Yiisoft\Html\Tag\Legend;

final class FieldsetTest extends TestCase
{
    public function testBase(): void
    {
        $tag = Fieldset::tag()
            ->legend('Personal data')
            ->content(
                Html::textInput('first_name'),
                "\n",
                Html::textInput('last_name'),
                "\n"
            );

        $this->assertSame(
            <<<HTML
            <fieldset>
            <legend>Personal data</legend>
            <input type="text" name="first_name">
            <input type="text" name="last_name">
            </fieldset>
            HTML,
            $tag->render()
        );
    }

    public static function dataLegend(): array
    {
        return [
            [
                '<fieldset></fieldset>',
                null,
            ],
            [
                <<<HTML
                <fieldset>
                <legend>Hello</legend>
                </fieldset>
                HTML,
                'Hello',
            ],
            [
                <<<HTML
                <fieldset>
                <legend id="MyLegend">Hello</legend>
                </fieldset>
                HTML,
                'Hello',
                ['id' => 'MyLegend'],
            ],
        ];
    }

    #[DataProvider('dataLegend')]
    public function testLegend(string $expected, $content, array $attributes = []): void
    {
        $tag = Fieldset::tag()->legend($content, $attributes);

        $this->assertSame($expected, $tag->render());
    }

    public static function dataLegendTag(): array
    {
        return [
            [
                '<fieldset></fieldset>',
                null,
            ],
            [
                <<<HTML
                <fieldset>
                <legend id="MyLegend">Hello</legend>
                </fieldset>
                HTML,
                Legend::tag()
                    ->content('Hello')
                    ->attributes(['id' => 'MyLegend']),
            ],
        ];
    }

    #[DataProvider('dataLegendTag')]
    public function testLegendTag(string $expected, ?Legend $legend): void
    {
        $tag = Fieldset::tag()->legendTag($legend);

        $this->assertSame($expected, $tag->render());
    }

    public static function dataDisabled(): array
    {
        return [
            [
                '<fieldset></fieldset>',
                null,
            ],
            [
                '<fieldset></fieldset>',
                false,
            ],
            [
                '<fieldset disabled></fieldset>',
                true,
            ],
        ];
    }

    #[DataProvider('dataDisabled')]
    public function testDisabled(string $expected, ?bool $disabled): void
    {
        $tag = Fieldset::tag()->disabled($disabled);

        $this->assertSame($expected, $tag->render());
    }

    public function testDisabledDefault(): void
    {
        $tag = Fieldset::tag()->disabled();

        $this->assertSame('<fieldset disabled></fieldset>', $tag->render());
    }

    public static function dataForm(): array
    {
        return [
            ['<fieldset></fieldset>', null],
            ['<fieldset form="post"></fieldset>', 'post'],
        ];
    }

    #[DataProvider('dataForm')]
    public function testForm(string $expected, ?string $formId): void
    {
        $tag = Fieldset::tag()->form($formId);

        $this->assertSame($expected, $tag->render());
    }

    public static function dataProviderName(): array
    {
        return [
            ['<fieldset></fieldset>', null],
            ['<fieldset name="personal_data"></fieldset>', 'personal_data'],
        ];
    }

    #[DataProvider('dataProviderName')]
    public function testName(string $expected, ?string $formId): void
    {
        $tag = Fieldset::tag()->name($formId);

        $this->assertSame($expected, $tag->render());
    }

    public function testImmutability(): void
    {
        $tag = Fieldset::tag();

        $this->assertNotSame($tag, $tag->legend(null));
        $this->assertNotSame($tag, $tag->legendTag(null));
        $this->assertNotSame($tag, $tag->disabled());
        $this->assertNotSame($tag, $tag->form(null));
        $this->assertNotSame($tag, $tag->name(null));
    }
}
