<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px">
    </a>
    <h1 align="center">Yii HTML</h1>
    <br>
</p>

[![Latest Stable Version](https://poser.pugx.org/yiisoft/html/v/stable.png)](https://packagist.org/packages/yiisoft/html)
[![Total Downloads](https://poser.pugx.org/yiisoft/html/downloads.png)](https://packagist.org/packages/yiisoft/html)
[![Build Status](https://github.com/yiisoft/html/workflows/build/badge.svg)](https://github.com/yiisoft/html/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/html/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/html/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/html/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/html/?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%2Fhtml%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/html/master)
[![static analysis](https://github.com/yiisoft/html/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/html/actions?query=workflow%3A%22static+analysis%22)
[![type-coverage](https://shepherd.dev/github/yiisoft/html/coverage.svg)](https://shepherd.dev/github/yiisoft/html)

The package provides various tools to help with dynamic server-side generation of HTML:

- Tag classes `A`, `Address`, `Article`, `Aside`, `Audio`, `B`, `Body`, `Br`, `Button`, `Caption`, `Col`, `Colgroup`,
 `Datalist`, `Div`, `Em`, `Fieldset`, `Footer`, `Form`, `H1`, `H2`, `H3`, `H4`, `H5`, `H6`, `Header`, `Hgroup`, `I`,
 `Img`, `Input` (and specialized `Checkbox`, `Radio`, `Range`, `File`), `Label`, `Legend`, `Li`, `Link`, `Meta`, `Nav`, 
 `Noscript`, `Ol`, `Optgroup`, `Option`, `P`, `Picture`, `Script`, `Section`, `Select`, `Source`, `Span`, `Strong`,
 `Style`, `Table`, `Tbody`, `Td`, `Textarea`, `Tfoot`, `Th`, `Thead`, `Title`, `Tr`, `Track`, `Ul`, `Video`.
- `CustomTag` class that helps to generate custom tag with any attributes.
- HTML widgets `ButtonGroup`, `CheckboxList` and `RadioList`.
- All tags content is automatically HTML-encoded. There is `NoEncode` class designed to wrap content that should not be encoded.
- `Html` helper that has static methods to generate HTML, create tags and HTML widget objects.

Note that for simple static-HTML cases, it is preferred to use HTML directly.

## Requirements

- PHP 7.4 or higher.

## Installation

```shell
composer require yiisoft/html --prefer-dist
```

## General usage

```php
<?php

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Meta;

?>

<?= Meta::pragmaDirective('X-UA-Compatible', 'IE=edge') ?>
<?= Meta::data('viewport', 'width=device-width, initial-scale=1') ?>

<?= Html::cssFile(
    'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
    [
        'integrity' => 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T',
        'crossorigin' => 'anonymous'
    ]
) ?>
<?= Html::cssFile('/css/site.css', ['rel' => 'stylesheet']) ?>

<?= Html::openTag('footer', ['class' => 'footer']) ?>
    <?= Html::openTag('div', ['class' => 'container flex-fill']) ?>
        <?= Html::p('', ['class' => 'float-left']) ?>
        <?= Html::p()
            ->replaceClass('float-right')
            ->content(
                'Powered by ',
                Html::a(
                    'Yii Framework',
                    'https://www.yiiframework.com/',
                    ['rel' => 'external']
                )
            ) ?>
    <?= Html::closeTag('div') ?>
<?= Html::closeTag('footer') ?>
```

## Tag objects usage

Tag classes allow working with a tag as an object and then get an HTML code by using `render()` method or type casting
to string. For example, the following code:

```php
echo \Yiisoft\Html\Tag\Div::tag()
    ->content(
        \Yiisoft\Html\Tag\A::tag()
            ->mailto('info@example.com')
            ->content('contact us')
            ->render()
    )
    ->encode(false)
    ->id('ContactEmail')
    ->replaceClass('red');
```

... will generate the following HTML:

```html
<div id="ContactEmail" class="red"><a href="mailto:info@example.com">contact us</a></div>
```

### Generating custom tags 

To generate custom tags, use the `CustomTag` class. For example, the following code:

```php
echo \Yiisoft\Html\Tag\CustomTag::name('b')
    ->content('text')
    ->attribute('title', 'Important');
```

... will generate the following HTML:

```html
<b title="Important">text</b>
```

### Encoding tags content

By default, stringable objects that implement `\Yiisoft\Html\NoEncodeStringableInterface` are not encoded,
everything else is encoded.

To change this behavior use `encode()` method passing one of the following values:
- `null`: default behavior;
- `true`: any content is encoded;
- `false`: nothing is encoded.
 
> Note: all bundled tags and widgets implement `\Yiisoft\Html\NoEncodeStringableInterface` interface and are not encoded
> by default when passed as content. Their own content is encoded.

Examples:

```php
// <b>&lt;i&gt;hello&lt;/i&gt;</b>
echo Html::b('<i>hello</i>');

// <b><i>hello</i></b>
echo Html::b('<i>hello</i>')->encode(false);

// <b><i>hello</i></b>
echo Html::b(Html::i('hello'));

// <b>&lt;i&gt;hello&lt;/i&gt;</b>
echo Html::b(Html::i('hello'))->encode(true);
```

In order to mark a string as "do not encode" you can use `\Yiisoft\Html\NoEncode` class:

```php
// <b><i>hello</i></b>
echo Html::b(NoEncode::string('<i>hello</i>'));
```

## HTML widgets usage

There are multiple widgets that do not directly represent any HTML tag, but a set of tags. These help to express
complex HTML in simple PHP.

### `ButtonGroup`

Represents a group of buttons.

```php
echo \Yiisoft\Html\Widget\ButtonGroup::create()
	->buttons(
	    \Yiisoft\Html\Html::resetButton('Reset Data'),
	    \Yiisoft\Html\Html::resetButton('Send'),
	)
	->containerAttributes(['class' => 'actions'])
	->replaceButtonAttributes(['form' => 'CreatePost']);
```

Result will be:

```html
<div class="actions">
<button type="reset" form="CreatePost">Reset Data</button>
<button type="reset" class="primary" form="CreatePost">Send</button>
</div>
```

### `CheckboxList`

Represents a list of checkboxes.

```php
echo \Yiisoft\Html\Widget\CheckboxList\CheckboxList::create('count')
	->items([1 => 'One', 2 => 'Two', 5 => 'Five'])
	->uncheckValue(0)
	->value(2, 5)
	->containerAttributes(['id' => 'main']);
```

Result will be:

```html
<input type="hidden" name="count" value="0">
<div id="main">
<label><input type="checkbox" name="count[]" value="1"> One</label>
<label><input type="checkbox" name="count[]" value="2" checked> Two</label>
<label><input type="checkbox" name="count[]" value="5" checked> Five</label>
</div>
```

### `RadioList`

Represents a list of radio buttons.

```php
echo \Yiisoft\Html\Widget\RadioList\RadioList::create('count')
    ->items([1 => 'One', 2 => 'Two', 5 => 'Five'])
    ->uncheckValue(0)
    ->value(2)
    ->containerAttributes(['id' => 'main'])
    ->render();
```

Result will be:

```html
<input type="hidden" name="test" value="0">
<div id="main">
<label><input type="radio" name="test" value="1"> One</label>
<label><input type="radio" name="test" value="2" checked> Two</label>
<label><input type="radio" name="test" value="5"> Five</label>
</div>
```

## `Html` helper usage

`Html` helper methods are static so usage is:

```php
echo \Yiisoft\Html\Html::a('Yii Framework', 'https://www.yiiframework.com/');
```

Overall the helper has the following method groups.

### Creating tag objects

#### Custom tags

- tag
- normalTag
- voidTag

#### Base tags

- b
- div
- em
- i
- meta
- p
- br
- script
- noscript
- span
- strong
- style
- title

#### Media tags

- img
- picture
- audio
- video
- track
- source

#### Heading tags

- h1
- h2
- h3
- h4
- h5
- h6

#### Section tags

- body
- article
- section
- nav
- aside
- hgroup
- header
- footer
- address

#### List tags

- ul
- ol
- li

#### Hyperlink tags

- a
- mailto

#### Link tags

- link
- cssFile
- javaScriptFile

#### Form tags

- button
- buttonInput
- checkbox
- file
- datalist
- fieldset
- fileInput
- form
- hiddenInput
- input
- label
- legend
- optgroup
- option
- passwordInput
- radio
- resetButton
- resetInput
- select
- submitButton
- submitInput
- textInput
- textarea

#### Table tags

- table
- caption
- colgroup
- col
- thead
- tbody
- tfoot
- tr
- th
- td

### Generating tag parts

- openTag
- closeTag
- renderTagAttributes

### Creating HTML widget objects

- radioList
- checkboxList

### Working with tag attributes

- generateId
- getArrayableName
- getNonArrayableName
- normalizeRegexpPattern

### Encode and escape special characters

- encode
- encodeAttribute
- encodeUnquotedAttribute
- escapeJavaScriptStringValue

### Working with CSS styles and classes

- addCssStyle
- removeCssStyle
- addCssClass
- removeCssClass
- cssStyleFromArray
- cssStyleToArray

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The Yii HTML is free software. It is released under the terms of the BSD License. Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).

## Support the project

[![Open Collective](https://img.shields.io/badge/Open%20Collective-sponsor-7eadf1?logo=open%20collective&logoColor=7eadf1&labelColor=555555)](https://opencollective.com/yiisoft)

## Follow updates

[![Official website](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](https://www.yiiframework.com/)
[![Twitter](https://img.shields.io/badge/twitter-follow-1DA1F2?logo=twitter&logoColor=1DA1F2&labelColor=555555?style=flat)](https://twitter.com/yiiframework)
[![Telegram](https://img.shields.io/badge/telegram-join-1DA1F2?style=flat&logo=telegram)](https://t.me/yii3en)
[![Facebook](https://img.shields.io/badge/facebook-join-1DA1F2?style=flat&logo=facebook&logoColor=ffffff)](https://www.facebook.com/groups/yiitalk)
[![Slack](https://img.shields.io/badge/slack-join-1DA1F2?style=flat&logo=slack)](https://yiiframework.com/go/slack)
