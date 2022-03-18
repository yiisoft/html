<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Picture;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Source;

final class PictureTest extends TestCase
{
    public function testBase(): void
    {
        $picture = Picture::tag()
            ->image(Img::tag()->src('img_orange_flowers.jpg')->alt('Flowers'))
            ->sources(
                Source::tag()->media('(min-width:650px)')->srcset('img_pink_flowers.jpg')->type('image/jpeg'),
                Source::tag()->media('(min-width:465px)')->srcset('img_white_flower.jpg')->type('image/jpeg')
            );

        $this->assertSame(
            '<picture>' . "\n" .
            '<source type="image/jpeg" srcset="img_pink_flowers.jpg" media="(min-width:650px)">' . "\n" .
            '<source type="image/jpeg" srcset="img_white_flower.jpg" media="(min-width:465px)">' . "\n" .
            '<img src="img_orange_flowers.jpg" alt="Flowers">' . "\n" .
            '</picture>',
            $picture->render()
        );
    }

    public function dataImg(): array
    {
        return [
            ['<picture></picture>', null],
            [
                '<picture>' . "\n" . '<img src="image.jpg" width="100" height="100">' . "\n" . '</picture>',
                Img::tag()->src('image.jpg')->width(100)->height(100),
            ],
        ];
    }

    /**
     * @dataProvider dataImg
     */
    public function testImg(string $expected, ?Img $img): void
    {
        $this->assertSame($expected, Picture::tag()->image($img)->render());
    }

    public function testImmutability(): void
    {
        $tag = Picture::tag();
        $this->assertNotSame($tag, $tag->image(null));
    }
}
