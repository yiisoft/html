<?php

declare(strict_types=1);

namespace Yiisoft\Html\Attribute;

use Attribute;

#[Attribute]
final class Deprecated
{
    public function __construct(
        public readonly ?string $message,
        public readonly ?string $since,
    ) {}
}

if (!class_exists('Deprecated')) {
    class_alias(Deprecated::class, 'Deprecated');
}
