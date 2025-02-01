<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Munderover;

final class MunderoverTest extends TestCase
{
    public static function accentDataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @dataProvider accentDataProvider
     */
    public function testAccent(bool $accent): void
    {
        $munderover = Munderover::tag()->accent($accent);

        $this->assertSame('<munderover accent="' . ($accent ? 'true' : 'false') . '"></munderover>', (string) $munderover);
    }

    public static function accentunderDataProvider(): array
    {
        return [
            [true],
            [false],
        ];
    }

    /**
     * @dataProvider accentunderDataProvider
     */
    public function testAccentunder(bool $accentunder): void
    {
        $munderover = Munderover::tag()->accentunder($accentunder);

        $this->assertSame('<munderover accentunder="' . ($accentunder ? 'true' : 'false') . '"></munderover>', (string) $munderover);
    }
}
