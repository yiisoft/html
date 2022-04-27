<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Tag;

use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Tag\Article;
use Yiisoft\Html\Tag\Footer;
use Yiisoft\Html\Tag\H1;
use Yiisoft\Html\Tag\Header;
use Yiisoft\Html\Tag\P;

final class ArticleTest extends TestCase
{
    public function testBase(): void
    {
        $this->assertSame(
            '<article><header><h1>Heading 1</h1></header><p>Article content</p><footer>Footer</footer></article>',
            (string) Article::tag()
                ->content(
                    Header::tag()->content(H1::tag()->content('Heading 1'))
                    . P::tag()->content('Article content')
                    . Footer::tag()->content('Footer')
                )->encode(false)
        );
    }
}
