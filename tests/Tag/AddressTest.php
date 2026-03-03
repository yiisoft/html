<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Address;

final class AddressTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<address>Street 111, Mount View Town. Contact: <a href="tel:xx-xx-xxxx">xx-xx-xxxx</a></address>',
            (string) new Address()
                ->content(
                    'Street 111, Mount View Town. Contact: '
                    . new A()
                        ->href('tel:xx-xx-xxxx')
                        ->content('xx-xx-xxxx'),
                )
                ->encode(false),
        );
    }
}
