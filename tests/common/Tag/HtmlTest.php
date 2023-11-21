<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Html;

final class HtmlTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<html>Welcome!</html>',
            (string) Html::tag()->content('Welcome!')
        );
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<html onafterprint="alert(123);" style="font-size:20px;">Welcome Back!</html>',
            (string) Html::tag()
                ->attributes([
                    'onafterprint' => 'alert(123);',
                    'style' => 'font-size:20px;',
                ])
                ->content('Welcome Back!')
        );
    }

    public function dataLang(): array
    {
        return [
            ['<html></html>', null],
            ['<html lang="en"></html>', 'en'],
        ];
    }

    /**
     * @dataProvider dataLang
     */
    public function testLang(string $expected, ?string $href): void
    {
        $this->assertSame($expected, (string)Html::tag()->lang($href));
    }
}
