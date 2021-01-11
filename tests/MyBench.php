<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests;

use Yiisoft\Html\Html;
use Yiisoft\Html\Span;
use Yiisoft\Html\SpanNoClone;

/**
 * @Iterations(10)
 * @Revs(1)
 * @BeforeMethods({"before"})
 */
final class MyBench
{
    private array $content;
    private array $class;
    private array $id;
    private array $data;

    public function before()
    {
        for ($i = 0; $i < 200; $i++) {
            $this->content[] = $this->random(128);
            $this->class[] = $this->random(24);
            $this->id[] = $this->random(24);
            $this->data[] = [
                'firstName' => $this->random(12),
                'lastName' => $this->random(18),
            ];
        }
    }

    private function random(int $length): string
    {
        $bytes = random_bytes((int)ceil($length * 0.75));
        return substr(strtr(base64_encode($bytes), '+/', '-_'), 0, $length);
    }

    public function benchObject()
    {
        $c = count($this->content);
        for ($i = 0; $i < $c; $i++) {
            $html = (string)(new Span())
                ->withContent($this->content[$i])
                ->withClass($this->class[$i])
                ->withId($this->id[$i])
                ->withData($this->data[$i]);
        }
    }

    public function benchObjectNoClone()
    {
        $c = count($this->content);
        for ($i = 0; $i < $c; $i++) {
            $html = (string)(new SpanNoClone())
                ->withContent($this->content[$i])
                ->withClass($this->class[$i])
                ->withId($this->id[$i])
                ->withData($this->data[$i]);
        }
    }

    public function benchStatic()
    {
        $c = count($this->content);
        for ($i = 0; $i < $c; $i++) {
            $html = Html::span($this->content[$i], [
                'class' => $this->class[$i],
                'id' => $this->id[$i],
                'data' => $this->data[$i],
            ]);
        }
    }
}
