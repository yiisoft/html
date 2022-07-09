# Yii HTML Change Log

## 2.5.0 July 09, 2022

- New #122: Add `Tag::addAttributes()`, `ButtonGroup::addButtonAttributes()`, `RadioList::addRadioAttributes()`,
 `RadioList::addIndividualInputAttributes()`, `CheckboxList::addCheckboxAttributes()`,
 `CheckboxList::addIndividualInputAttributes()`, `File::addUncheckInputAttributes()`, `Range::addOutputAttributes()` and 
 deprecate `Tag::attributes()`, `ButtonGroup::buttonAttributes()`, `RadioList::radioAttributes()`,
 `RadioList::individualInputAttributes()`, `CheckboxList::checkboxAttributes()`,
 `CheckboxList::individualInputAttributes()`, `File::uncheckInputAttributes()`, `Range::outputAttributes()` (@vjik)
- New #123: Add `Tag::addClass()` and deprecate `Tag::class()` (@vjik)
- New #129: Add methods `enctypeApplicationXWwwFormUrlencoded()`, `enctypeMultipartFormData()` and `enctypeTextPlain()`
  to `Form` tag class (@vjik) 

## 2.4.0 May 19, 2022

- New #97: Add classes for tags `Body`, `Article`, `Section`, `Nav`, `Aside`, `Hgroup`, `Header`, `Footer`, `Address`
  and methods `Html::body()`, `Html::article()`, `Html::section()`, `Html::nav()`, `Html::aside()`, `Html::hgroup()`,
  `Html::header()`, `Html::footer()`, `Html::address()` (@soodssr)
- New #103: Add class for tag `Form` and method `Html::form()` (@vjik)
- New #105: Add specialized class `File` for an input tag with type `file` and methods `Html::file()` and
  `Input::fileControl()` (@vjik)
- New #109: Add class for tag `Datalist` and method `Html::datalist()` (@vjik)
- New #109, #117: Add specialized class for input tag with type `Range` and methods `Html::range()`,
 `Input::range()` (@vjik)
- New #111: Add widget `ButtonGroup` (@vjik)
- New #111: Add method `Tag::unionAttributes()` that available for all tags (@vjik)
- New #113: Add class for tag `Legend`, class for tag `Fieldset`, methods `Html::legend()` and `Html::fieldset()` (@vjik)
- Enh #102: Remove psalm type `HtmlAttributes`, too obsessive for package users (@vjik)
- Enh #104: Add parameter `$attributes` to methods `Html::input()`, `Html::buttonInput()`, `Html::submitInput()` 
  and `Html::resetInput()` (@vjik)
- Enh #106: Add option groups support to method `Select::optionsData()` (@vjik)
- Enh #108: Add individual attributes of options and option groups support to method `Select::optionsData()` (@vjik)
- Enh #115: Add methods `CheckboxList::name()` and `RadioList::name()` (@vjik)

## 2.3.0 March 25, 2022

- New #95: Add class for tag `Title` and method `Html::title()` (@vjik)
- New #96: Add classes for heading tags `H1-6` and methods `Html::h1()`, `Html::h2()`, `Html::h3()`, `Html::h4()`,
  `Html::h5()`, `Html::h6()` (@vjik)
- New #100: Add classes for tags `Picture`, `Audio`, `Video`, `Source` and `Track` (@Gerych1984, @vjik)

## 2.2.1 October 24, 2021

- Enh #93: Add support for `yiisoft/arrays` version `^2.0` (@vjik)

## 2.2.0 October 20, 2021

- New #89: Add method `nofollow()` to the `A` tag (@soodssr)
- New #90: Add method `itemsFromValues()` to widgets `RadioList` and `CheckboxList` that set items with labels equal
  to values (@vjik)
- New #92: A third optional argument `$attributes` containing tag attributes in terms of name-value pairs has been
  added to methods `Html::textInput()`, `Html::hiddenInput()`, `Html::passwordInput()`, `Html::fileInput()`,
  `Html::radio()`, `Html::checkbox()`, `Html::textarea()` (@vjik)

## 2.1.0 September 23, 2021

- New #88: Add `Noscript` tag support and shortcuts for `Script` tag via methods `Script::noscript()`
  and `Script::noscriptTag()` (@vjik)

## 2.0.0 August 24, 2021

- New #74: Add classes for tags `Em`, `Strong`, `B` and `I` (@vjik)
- New #75: Add methods `as()` and `preload()` to the `Link` tag (@vjik)
- New #76: Add `NoEncode` class designed to wrap content that should not be encoded in HTML tags (@vjik)
- New #78: Allow pass `null` argument to methods `Tag::class()`, `Tag::replaceClass()`, `BooleanInputTag::label()` and
  `BooleanInputTag::sideLabel()` (@vjik)
- New #82: Add support individual attributes for inputs in `CheckboxList` and `RadioList` widgets via methods
  `CheckboxList::individualInputAttributes()`, `CheckboxList::replaceIndividualInputAttributes()`,
  `RadioList::individualInputAttributes()` and `RadioList::replaceIndividualInputAttributes()` (@vjik)
- Chg #79: Do not add empty attribute value for empty strings (@vjik)
- Bug #83: Fix `Html::ATTRIBUTE_ORDER` values (@terabytesoftw)

## 1.2.0 May 04, 2021

- New #70: Add support `\Stringable` as content in methods `Html::tag()`, `Html::normalTag()`, `Html::a()`,
  `Html::label()`, `Html::option()`, `Html::div()`, `Html::span()`, `Html::p()`, `Html::li()`, `Html::caption()`,
  `Html::td()`, `Html::th()` (@vjik)
- New #71: Add methods `Script::getContent()` and `Style::getContent()` (@vjik)

## 1.1.0 April 09, 2021

- New #65: Add classes for table tags `Table`, `Caption`, `Colgroup`, `Col`, `Thead`, `Tbody`, `Tfoot`, `Tr`, `Th`, `Td` (@vjik)
- New #69: Add class for tag `Br` (@vjik)

## 1.0.1 April 04, 2021

- Bug #68: Fix `TagContentTrait::content()` and `TagContentTrait::addContent()` when used with named parameters (@vjik)

## 1.0.0 March 17, 2021

- Initial release.
