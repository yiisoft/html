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
            (string) Nav::tag()->content(
                Ul::tag()->items(
                    Li::tag()->content('Home'),
                    Li::tag()->content('About Us'),
                    Li::tag()->content('Contact Us')
                )
            )
        );
    }
}
