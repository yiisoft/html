<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Details;
use Yiisoft\Html\Tag\P;
use Yiisoft\Html\Tag\Summary;

final class DetailsTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<details><summary>Info</summary><p>Details content</p></details>',
            (string) (new Details())
                ->content(
                    (new Summary())->content('Info')
                    . (new P())->content('Details content'),
                )
                ->encode(false),
        );
    }
}
