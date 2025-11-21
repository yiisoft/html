<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use Yiisoft\Html\Tag\Caption;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\CustomTag;

final class CaptionTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<caption>Table <b>Caption</b></caption>',
            Caption::tag()
                ->content(
                    'Table ',
                    CustomTag::name('b')->content('Caption'),
                )
                ->render(),
        );
    }
}
