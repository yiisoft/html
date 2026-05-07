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

    public function testGenerateIdWithSeedEnabled(): void
    {
        $this->assertMatchesRegularExpression('/^i\d+$/', Html::generateId());
        $this->assertMatchesRegularExpression('/^test\d+$/', Html::generateId('test'));
    }

    public function testGenerateIdWithSeedDisabled(): void
    {
        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
        $this->assertSame('i2', Html::generateId());
        $this->assertSame('i3', Html::generateId());
    }

    public function testGenerateIdWithSeedDisabledCustomPrefix(): void
    {
        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();

        $this->assertSame('test1', Html::generateId('test'));
        $this->assertSame('test2', Html::generateId('test'));
    }

    public function testGenerateIdWithSeedDisabledMixedPrefixesDoNotResetEachOther(): void
    {
        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
        $this->assertSame('test1', Html::generateId('test'));
        $this->assertSame('i2', Html::generateId());
        $this->assertSame('test2', Html::generateId('test'));
    }

    public function testResetClearsCounterWithoutChangingSeedMode(): void
    {
        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
        $this->assertSame('i2', Html::generateId());

        \Yiisoft\Html\IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
    }

    public function testEnableSeedRestoresTimestampBehavior(): void
    {
        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();
        $this->assertSame('i1', Html::generateId());

        \Yiisoft\Html\IdGenerator\enableSeed();

        $this->assertMatchesRegularExpression('/^i\d{10,}/', Html::generateId());
    }
}
