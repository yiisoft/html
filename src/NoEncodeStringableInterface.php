<?php

declare(strict_types=1);

namespace Yiisoft\Html;

use Stringable;

/**
 * An object that could be cast to string that should not be HTML-encoded when used.
 */
interface NoEncodeStringableInterface extends Stringable
{
}
