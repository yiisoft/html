# Yii HTML Change Log


## 1.2.0 May 04, 2021

- Enh #70: Add support `\Stringable` as content in methods `Html::tag()`, `Html::normalTag()`, `Html::a()`,
  `Html::label()`, `Html::option()`, `Html::div()`, `Html::span()`, `Html::p()`, `Html::li()`, `Html::caption()`,
  `Html::td()`, `Html::th()` (vjik)
- Enh #71: Add methods `Script::getContent()` and `Style::getContent()` (vjik)

## 1.1.0 April 09, 2021

- Enh #65: Add classes for table tags `Table`, `Caption`, `Colgroup`, `Col`, `Thead`, `Tbody`, `Tfoot`, `Tr`, `Th`, `Td` (vjik)
- Enh #69: Add class for tag `Br` (vjik)

## 1.0.1 April 04, 2021

- Bug #68: Fix `TagContentTrait::content()` and `TagContentTrait::addContent()` when used with named parameters (vjik)

## 1.0.0 March 17, 2021

- Initial release.
