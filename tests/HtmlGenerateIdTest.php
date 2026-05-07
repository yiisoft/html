<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;

final class HtmlGenerateIdTest extends TestCase
{
    protected function tearDown(): void
    {
        \Yiisoft\Html\IdGenerator\enableSeed();
    }

    public function testGenerateId(): void
    {
        \Yiisoft\Html\IdGenerator\enableSeed();
        $this->assertMatchesRegularExpression('/i\d+/', Html::generateId());
        $this->assertMatchesRegularExpression('/test\d+/', Html::generateId('test'));

        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();
        $this->assertSame('i1', Html::generateId());
        $this->assertSame('i2', Html::generateId());

        \Yiisoft\Html\IdGenerator\reset();
        $this->assertSame('i1', Html::generateId());
    }
}
