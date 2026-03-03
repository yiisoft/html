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
        $tag = new Datalist()
            ->id('numbers')
            ->content(
                new Option()->value('One'),
                new Option()->value('Two'),
            );

        $this->assertSame(
            '<datalist id="numbers"><option value="One"></option><option value="Two"></option></datalist>',
            $tag->render(),
        );
    }
}
