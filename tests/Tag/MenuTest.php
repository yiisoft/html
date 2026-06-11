<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Menu;

final class MenuTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            "<menu>\n<li>Item 1</li>\n<li>Item 2</li>\n</menu>",
            (string) (new Menu())->items(
                (new Li())->content('Item 1'),
                (new Li())->content('Item 2'),
            ),
        );
    }
}
