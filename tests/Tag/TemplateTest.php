<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Template;

final class TemplateTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<template class="red">Hello</template>',
            (string) (new Template())
                ->class('red')
                ->content('Hello'),
        );
    }
}
