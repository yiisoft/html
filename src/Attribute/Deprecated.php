<?php

declare(strict_types=1);

namespace Yiisoft\Html\Attribute;

use Attribute;

use const E_USER_DEPRECATED;

#[Attribute]
final class Deprecated
{
    public function __construct(
        public readonly ?string $message,
        public readonly ?string $since,
    ) {
        trigger_error($message ?? '', E_USER_DEPRECATED);
    }
}

if (!class_exists('Deprecated')) {
    class_alias(Deprecated::class, 'Deprecated');
}
