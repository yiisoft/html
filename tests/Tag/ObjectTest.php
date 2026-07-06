<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\ObjectTag;

final class ObjectTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<object class="red">Content</object>',
            (string) (new ObjectTag())
                ->class('red')
                ->content('Content'),
        );
    }

    public function testData(): void
    {
        $this->assertSame(
            '<object data="https://example.com/app">Content</object>',
            (string) (new ObjectTag())->data('https://example.com/app')->content('Content'),
        );
    }

    public function testForm(): void
    {
        $this->assertSame(
            '<object form="form1">Content</object>',
            (string) (new ObjectTag())->form('form1')->content('Content'),
        );
    }

    public function testName(): void
    {
        $this->assertSame(
            '<object name="app">Content</object>',
            (string) (new ObjectTag())->name('app')->content('Content'),
        );
    }

    public function testType(): void
    {
        $this->assertSame(
            '<object type="application/pdf">Content</object>',
            (string) (new ObjectTag())->type('application/pdf')->content('Content'),
        );
    }

    public function testWidth(): void
    {
        $this->assertSame(
            '<object width="640">Content</object>',
            (string) (new ObjectTag())->width(640)->content('Content'),
        );
    }

    public function testHeight(): void
    {
        $this->assertSame(
            '<object height="480">Content</object>',
            (string) (new ObjectTag())->height(480)->content('Content'),
        );
    }

    public function testImmutability(): void
    {
        $object = new ObjectTag();
        $this->assertNotSame($object, $object->data(null));
        $this->assertNotSame($object, $object->form(null));
        $this->assertNotSame($object, $object->name(null));
        $this->assertNotSame($object, $object->type(null));
        $this->assertNotSame($object, $object->width(null));
        $this->assertNotSame($object, $object->height(null));
    }
}
