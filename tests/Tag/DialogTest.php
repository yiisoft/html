<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Dialog;
use Yiisoft\Html\Tag\P;

final class DialogTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<dialog><p>Content</p></dialog>',
            (string) (new Dialog())
                ->content(
                    (new P())->content('Content'),
                ),
        );
    }
}
