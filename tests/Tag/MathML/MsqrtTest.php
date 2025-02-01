<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\MathML;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\MathML\Mi;
use Yiisoft\Html\Tag\MathML\Msqrt;

final class MsqrtTest extends TestCase
{
    public function testSimple(): void
    {
        $msqrt = Msqrt::tag()
            ->items(
                Mi::tag()->identifier('x'),
            );

        $this->assertSame(
            '<msqrt>' . "\n" .
            '<mi>x</mi>' . "\n" .
            '</msqrt>',
            (string) $msqrt
        );
    }
}
