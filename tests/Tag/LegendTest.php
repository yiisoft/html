<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Legend;

final class LegendTest extends TestCase
{
    public function testBase(): void
    {
        $tag = Legend::tag()->content('Personal data');
        $this->assertSame('<legend>Personal data</legend>', $tag->render());
    }
}
