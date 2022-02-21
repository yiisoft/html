<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Picture;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Source;

final class PictureTest extends TestCase
{
    public function testSimplePicture(): void
    {
        $img = Img::tag()->src('image.jpg')->width(100)->height(100);

        $this->assertSame(
            '<picture><img src="image.jpg" width="100" height="100"></picture>',
            Picture::tag()->image($img)->render()
        );

        $this->assertSame(
            '<picture><img src="image.jpg"></picture>',
            Picture::tag()->src('image.jpg')->render()
        );
    }

    public function testSourcePicture(): void
    {
        $img = Img::tag()->src('img_orange_flowers.jpg')->alt('Flowers');
        $pink = Source::tag()->media('(min-width:650px)')->srcset('img_pink_flowers.jpg')->type('image/jpeg');
        $white = Source::tag()->media('(min-width:465px)')->srcset('img_white_flower.jpg')->type('image/jpeg');
        $picture = Picture::tag()->image($img)->sources($pink, $white);
        $html = trim(str_replace('>', ">\n", $picture->render()));

        $expected = <<<'HTML'
        <picture>
        <source type="image/jpeg" srcset="img_pink_flowers.jpg" media="(min-width:650px)">
        <source type="image/jpeg" srcset="img_white_flower.jpg" media="(min-width:465px)">
        <img src="img_orange_flowers.jpg" alt="Flowers">
        </picture>
        HTML;

        $this->assertSame($expected, $html);
    }

    public function testPictureAttributes(): void
    {
        $pink = Source::tag()
            ->media('(min-width:650px)')
            ->srcset('img_pink_flowers.jpg')
            ->width(200)
            ->height(200)
            ->type('image/jpeg');
        $white = Source::tag()->media('(min-width:465px)')->srcset('img_white_flower.jpg')->type('image/jpeg');
        $picture = Picture::tag()
            ->src('img_orange_flowers.jpg')
            ->alt('Flowers')
            ->width(100)
            ->height(100)
            ->sources($pink, $white);
        $html = trim(str_replace('>', ">\n", $picture->render()));

        $expected = <<<'HTML'
        <picture>
        <source type="image/jpeg" srcset="img_pink_flowers.jpg" width="200" height="200" media="(min-width:650px)">
        <source type="image/jpeg" srcset="img_white_flower.jpg" media="(min-width:465px)">
        <img src="img_orange_flowers.jpg" width="100" height="100" alt="Flowers">
        </picture>
        HTML;

        $this->assertSame($expected, $html);
    }
}
