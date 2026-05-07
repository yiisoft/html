<?php

declare(strict_types=1);

namespace Yiisoft\Html;

/**
 * @internal
 */
final class IdGenerator
{
    /**
     * @var array<string, int>
     */
    public static array $counter = [];

    public static bool $useSeed = true;

    /**
     * @psalm-return non-empty-string
     */
    public static function generate(string $prefix): string
    {
        if (self::$useSeed) {
            $prefix .= hrtime(true);
        }
        if (isset(self::$counter[$prefix])) {
            $count = ++self::$counter[$prefix];
        } else {
            $count = 1;
            if (self::$useSeed) {
                self::$counter = [$prefix => $count];
            } else {
                self::$counter[$prefix] = $count;
            }
        }
        return $prefix . $count;
    }
}
