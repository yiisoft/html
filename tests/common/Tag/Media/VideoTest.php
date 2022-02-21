<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag\Media;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Media\Video;

final class VideoTest extends TestCase
{
    public function testSimpleVideo(): void
    {
        $video = Video::tag()->src('sample.mp4')->render();
        $expected = '<video src="sample.mp4"></video>';

        $this->assertSame($expected, $video);
    }
}
