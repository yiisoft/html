<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use Yiisoft\Html\Tag\Base\ContentTagArrayMap;
use Yiisoft\Html\Tag\Base\ContentTagWithoutArray;
use Yiisoft\Html\Tag\Base\ContentTagForeach;

/**
 * @Iterations(10)
 * @Revs(1)
 * @BeforeMethods({"before"})
 */
final class ContentBenchmark
{
    private array $contents = [];

    public function before()
    {
        for ($i = 0; $i < 200; $i++) {
            $this->contents[] = $this->random(128);
        }
    }

    private function random(int $length): string
    {
        $bytes = random_bytes((int)ceil($length * 0.75));
        return substr(strtr(base64_encode($bytes), '+/', '-_'), 0, $length);
    }

    private function run($tag)
    {
        foreach ($this->contents as $content) {
            $tag->content($content)->render();
        }
    }

    public function benchArrayMap()
    {
        $this->run(ContentTagArrayMap::tag());
    }

    public function benchForeach()
    {
        $this->run(ContentTagForeach::tag());
    }

    public function benchWithoutArray()
    {
        $this->run(ContentTagWithoutArray::tag());
    }
}
