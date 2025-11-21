<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Ol;

final class OlTest extends TestCase
{
    public function testBase(): void
    {
        $ol = Ol::tag()->items(
            Li::tag()->content('A'),
            Li::tag()->content('B'),
        );

        $this->assertSame("<ol>\n<li>A</li>\n<li>B</li>\n</ol>", (string) $ol);
    }
}
