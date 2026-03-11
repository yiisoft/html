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
            (string) (new Footer())
                ->content(
                    (new H3())->content('Heading 1')
                    . (new P())->content('Hello Text'),
                )
                ->encode(false),
        );
    }
}
