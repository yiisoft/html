<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Nav;
use Yiisoft\Html\Tag\Ul;

final class NavTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            "<nav><ul>\n<li>Home</li>\n<li>About Us</li>\n<li>Contact Us</li>\n</ul></nav>",
            (string) (new Nav())->content(
                (new Ul())->items(
                    (new Li())->content('Home'),
                    (new Li())->content('About Us'),
                    (new Li())->content('Contact Us'),
                ),
            ),
        );
    }
}
