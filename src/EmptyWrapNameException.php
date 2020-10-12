<?php

declare(strict_types=1);

namespace Yiisoft\Html;

use InvalidArgumentException;

final class EmptyWrapNameException extends InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Wrap name cannot be empty for tabluar attribute names.');
    }
}
