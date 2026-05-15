<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\IdGenerator;

final class HtmlGenerateIdTest extends TestCase
{
    protected function tearDown(): void
    {
        IdGenerator\reset();
        IdGenerator\enableSeed();

        parent::tearDown();
    }

    public function testGenerateIdWithSeedEnabled(): void
    {
        $this->assertMatchesRegularExpression('/^i\d+$/', Html::generateId());
        $this->assertMatchesRegularExpression('/^test\d+$/', Html::generateId('test'));
    }

    public function testGenerateIdWithSeedDisabled(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
        $this->assertSame('i2', Html::generateId());
        $this->assertSame('i3', Html::generateId());
    }

    public function testGenerateIdWithSeedDisabledCustomPrefix(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();

        $this->assertSame('test1', Html::generateId('test'));
        $this->assertSame('test2', Html::generateId('test'));
    }

    public function testGenerateIdWithSeedDisabledMixedPrefixesDoNotResetEachOther(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
        $this->assertSame('test1', Html::generateId('test'));
        $this->assertSame('i2', Html::generateId());
        $this->assertSame('test2', Html::generateId('test'));
    }

    public function testResetClearsCounterWithoutChangingSeedMode(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
        $this->assertSame('i2', Html::generateId());

        IdGenerator\reset();

        $this->assertSame('i1', Html::generateId());
    }

    public function testEnableSeedRestoresTimestampBehavior(): void
    {
        IdGenerator\disableSeed();
        IdGenerator\reset();
        $this->assertSame('i1', Html::generateId());

        IdGenerator\enableSeed();

        $this->assertMatchesRegularExpression('/^i\d{10,}/', Html::generateId());
    }
}
