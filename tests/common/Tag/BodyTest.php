<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Body;

final class BodyTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<body>Welcome!</body>',
            (string) Body::tag()->content('Welcome!')
        );
    }

    public function testAttributes(): void
    {
        $this->assertSame(
            '<body onafterprint="alert(123);" style="font-size:20px;">Welcome Back!</body>',
            (string) Body::tag()->attributes([
                'onafterprint' => 'alert(123);',
                'style' => 'font-size:20px;',
            ])->content('Welcome Back!')
        );
    }
}
