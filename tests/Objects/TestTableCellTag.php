<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Objects;

use Yiisoft\Html\Tag\Base\TableCellTag;

final class TestTableCellTag extends TableCellTag
{
    #[\Override]
    protected function getName(): string
    {
        return 'test';
    }
}
