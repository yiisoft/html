<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii HTML</h1>
    <br>
</p>

The package provides `Html` helper that has static methods to generate HTML.  

[![Latest Stable Version](https://poser.pugx.org/yiisoft/html/v/stable.png)](https://packagist.org/packages/yiisoft/html)
[![Total Downloads](https://poser.pugx.org/yiisoft/html/downloads.png)](https://packagist.org/packages/yiisoft/html)
[![Build Status](https://github.com/yiisoft/html/workflows/build/badge.svg)](https://github.com/yiisoft/html/actions)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/html/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/html/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/html/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/html/?branch=master)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fyiisoft%html%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/yiisoft/html/master)
[![static analysis](https://github.com/yiisoft/html/workflows/static%20analysis/badge.svg)](https://github.com/yiisoft/html/actions?query=workflow%3A%22static+analysis%22)

## Requirements

- PHP 7.4 or higher.

## Installation

```
composer require yiisoft/html
```

## General usage

```php
<?php

use Yiisoft\Html\Html;

?>

<?= Html::tag('meta', '', ['http-equiv' => 'X-UA-Compatible', 'content' => 'IE=edge']) ?>
<?= Html::tag('meta', '', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']) ?>

<?= Html::cssFile($aliases->get('@css/site.css'), ['rel' => 'stylesheet']); ?>

<?= Html::cssFile(
    'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css',
    [
        'rel' => 'stylesheet',
        'integrity' => 'sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T',
        'crossorigin' => 'anonymous'
    ]
); ?>

<?= Html::beginTag('footer', ['class' => 'footer']) ?>
    <?= Html::beginTag('div', ['class' => 'container flex-fill']) ?>
        <?= Html::beginTag('p', ['class' => 'float-left']) ?>
        <?= Html::endTag('p') ?>
        <?= Html::beginTag('p', ['class' => 'float-right']) ?>
            <?= 'Powered by' ?>
            <?= Html::a(
                'Yii Framework',
                'https://www.yiiframework.com/',
                ['rel' => 'external']
            ) ?>
        <?= Html::endTag('p') ?>
    <?= Html::endTag('div') ?>
<?= Html::endTag('footer') ?>
```

## Html helper usage

Html helper methods are static so usage is like the following:

```php
echo \Yiisoft\Html\Html::a('Yii Framework', 'https://www.yiiframework.com/') ?>
```

Overall the helper has the following method groups.

### Generating any tags

- beginTag
- endTag
- tag
- renderTagAttributes

### Generating base tags

- ul
- ol
- img
- style
- script

### Generating hyperlink tags

- a
- mailto

### Generating form tags

- booleanInput
- button
- buttonInput
- checkbox
- checkboxList
- dropDownList
- fileInput
- hiddenInput
- input
- label
- listBox
- passwordInput
- radio
- radioList
- renderSelectOptions
- resetButton
- resetInput
- submitButton
- submitInput
- textInput
- textarea

### Generating link tags

- cssFile
- jsFile

### Working with CSS styles and classes

- addCssStyle
- removeCssStyle
- addCssClass
- removeCssClass
- cssStyleFromArray
- cssStyleToArray

### Encode and decode special characters

- encode
- decode

### Other

- generateId
- escapeJsRegularExpression

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework. To run it:

```
./vendor/bin/infection
```

## Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```
./vendor/bin/psalm
```

## License

The Yii HTML is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

Maintained by [Yii Software](https://www.yiiframework.com/).
