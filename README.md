<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii HTML</h1>
    <br>
</p>

The package ...

[![Latest Stable Version](https://poser.pugx.org/yiisoft/html/v/stable.png)](https://packagist.org/packages/yiisoft/html)
[![Total Downloads](https://poser.pugx.org/yiisoft/html/downloads.png)](https://packagist.org/packages/yiisoft/html)
[![Build Status](https://travis-ci.com/yiisoft/html.svg?branch=master)](https://travis-ci.com/yiisoft/html)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/yiisoft/html/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/html/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/yiisoft/html/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/yiisoft/html/?branch=master)

### **REQUIREMENTS:**

- The minimum requirement by this project template that your Web server supports:
    - PHP 7.4 or higher.

### **INSTALLATION:**

<p align="justify">
If you do not have <a href="http://getcomposer.org/" title="Composer" target="_blank">Composer</a>, you may install it by following the instructions at <a href="http://getcomposer.org/doc/00-intro.md#installation-nix" title="getcomposer.org" target="_blank">getcomposer.org</a>.
</p>

You can then install this project template using the following command:

~~~
composer require yiisoft/html
~~~

## General usage

```php
use Yiisoft\Html\Html;

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
                'http://www.yiiframework.com/',
                ['rel' => 'external']
            ) ?>
        <?= Html::endTag('p') ?>
    <?= Html::endTag('div') ?>
<?= Html::endTag('footer') ?>
```
