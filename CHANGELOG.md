# Yii HTML Change Log

## 1.3.0 under development

- New #74: Add classes for tags `Em`, `Strong`, `B` and `I` (vjik)
- New #75: Add methods `as()` and `preload()` to the `Link` tag (vjik)
- New #78: Allow pass `null` argument to methods `Tag::class()`, `Tag::replaceClass()`, `BooleanInputTag::label()` and
  `BooleanInputTag::sideLabel()` (vjik)
- Chg #79: For attributes with empty string value generated only attribute name without value and character `=` (vjik)

## 1.2.0 May 04, 2021

- New #70: Add support `\Stringable` as content in methods `Html::tag()`, `Html::normalTag()`, `Html::a()`,
  `Html::label()`, `Html::option()`, `Html::div()`, `Html::span()`, `Html::p()`, `Html::li()`, `Html::caption()`,
  `Html::td()`, `Html::th()` (vjik)
- New #71: Add methods `Script::getContent()` and `Style::getContent()` (vjik)

## 1.1.0 April 09, 2021

- New #65: Add classes for table tags `Table`, `Caption`, `Colgroup`, `Col`, `Thead`, `Tbody`, `Tfoot`, `Tr`, `Th`, `Td` (vjik)
- New #69: Add class for tag `Br` (vjik)

## 1.0.1 April 04, 2021

- Bug #68: Fix `TagContentTrait::content()` and `TagContentTrait::addContent()` when used with named parameters (vjik)

## 1.0.0 March 17, 2021

- Initial release.
