<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Footer;
use Yiisoft\Html\Tag\H3;
use Yiisoft\Html\Tag\P;

final class FooterTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<footer><h3>Heading 1</h3><p>Hello Text</p></footer>',
            (string) Footer::tag()
                ->content(
                    H3::tag()->content('Heading 1')
                    . P::tag()->content('Hello Text')
                )->encode(false)
        );
    }
}
