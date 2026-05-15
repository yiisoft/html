<?php

declare(strict_types=1);

namespace Yiisoft\Html\IdGenerator;

use Yiisoft\Html\IdGenerator;
use Yiisoft\Html\Html;

/**
 * Resets the internal ID counter used by {@see Html::generateId()}.
 */
function reset(): void
{
    IdGenerator::$counter = [];
}

/**
 * Re-enables the `hrtime()` seed. {@see Html::generateId()} will include a timestamp again (default behaviour).
 */
function enableSeed(): void
{
    IdGenerator::$useSeed = true;
}

/**
 * Disables the `hrtime()` seed. {@see Html::generateId()} will produce short deterministic IDs: `i1`, `i2`, etc.
 */
function disableSeed(): void
{
    IdGenerator::$useSeed = false;
}
