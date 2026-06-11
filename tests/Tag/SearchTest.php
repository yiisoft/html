<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Search;

final class SearchTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<search class="red">Hello</search>',
            (string) (new Search())
                ->class('red')
                ->content('Hello'),
        );
    }
}
