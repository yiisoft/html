<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Main;
use Yiisoft\Html\Tag\P;

final class MainTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<main><p>Main Content</p></main>',
            (string) (new Main())
                ->content(
                    (new P())->content('Main Content'),
                ),
        );
    }
}
