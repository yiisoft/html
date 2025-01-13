<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\TableRowsContainerTag;

final class TestTableRowsContainerTag extends TableRowsContainerTag
{
    protected function getName(): string
    {
        return 'test';
    }
}
