<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Benchmark;

use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Iterations;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use Yiisoft\Html\Html;

/**
 * @BeforeMethods({"setUp"})
 */
class HtmlBench
{
    private array $attributes;
    private string $content;

    public function setUp(): void
    {
        $this->attributes = [
            'id' => 'test-id',
            'class' => 'test-class another-class',
            'data-test' => 'value',
            'aria-label' => 'Test Label',
            'style' => 'color: red; background: blue;',
        ];
        $this->content = 'Test content with <special> characters & symbols';
    }

    /**
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchDivCreation(): void
    {
        Html::div($this->content, $this->attributes)->render();
    }

    /**
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchFormCreation(): void
    {
        Html::form('/submit', 'POST', $this->attributes)->render();
    }

    /**
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchInputCreation(): void
    {
        Html::input('text', 'test_field', 'test_value', $this->attributes)->render();
    }

    /**
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchAttributeRendering(): void
    {
        Html::renderTagAttributes($this->attributes);
    }

    /**
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchEncoding(): void
    {
        Html::encode($this->content);
    }

    /**
     * @Revs(1000)
     * @Iterations(10)
     */
    public function benchAttributeEncoding(): void
    {
        Html::encodeAttribute($this->content);
    }
}