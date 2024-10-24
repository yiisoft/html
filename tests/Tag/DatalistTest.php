<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Datalist;
use Yiisoft\Html\Tag\Option;

final class DatalistTest extends TestCase
{
    public function testBase(): void
    {
        $tag = Datalist::tag()
            ->id('numbers')
            ->content(
                Option::tag()->value('One'),
                Option::tag()->value('Two'),
            );

        $this->assertSame(
            '<datalist id="numbers"><option value="One"></option><option value="Two"></option></datalist>',
            $tag->render()
        );
    }
}
