<?php

declare(strict_types=1);

namespace Yiisoft\Html;

use Yiisoft\Html\Tests\HtmlTest;

function hrtime(bool $getAsNumber = false)
{
    return HtmlTest::$hrtimeResult ?? \hrtime($getAsNumber);
}
