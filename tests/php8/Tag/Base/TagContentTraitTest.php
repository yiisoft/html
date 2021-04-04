<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Php8\Tag\Base;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tests\Objects\TestTagContentTrait;

final class TagContentTraitTest extends TestCase
{
    public function testNamedParametersContent(): void
    {
        $this->assertSame(
            '<test>123</test>',
            TestTagContentTrait::tag()
                ->content(content: '1')
                ->addContent(content: '2')
                ->addContent(content: '3')
                ->render()
        );
    }
}
