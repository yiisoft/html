# Yii HTML Change Log

## 3.11.0 June 10, 2025

- New #237: Add classes for `Code` and `Pre` tags, `Html::code()` and `Html::pre()` methods (@FrankiFixx)
- Enh #246: Add psalm type `OptionsData` in `Select` class (@vjik)
- Bug #245: Explicitly marking parameters as nullable (@Tigrov)

## 3.10.0 April 03, 2025

- Chg #240, #242: Change PHP constraint in `composer.json` to `8.1 - 8.4` (@vjik)
- Enh #223: Make `$content` parameter optional in `Button` factories (@FrankiFixx)
- Enh #244: Allow to pass `null` to `Select::value()` method (@vjik)
- Bug #232: Render `loading` attribute before `src` (@samdark)
- Bug #242: Fix the nullable parameter declarations for compatibility with PHP 8.4 (@vjik)

## 3.9.0 November 29, 2024

- Enh #230: Add backed enumeration value support to `Html::addCssClass()`, `Tag::addClass()` and `Tag::class()`
  methods (@terabytesoftw)

## 3.8.0 October 29, 2024

- New #224: Add optional `wrap` parameter to `BooleanInputTag::label()` method that controls whether to wrap input tag
  with label tag or place them aside (@vjik)
- New #225: Add `CheckboxList::checkboxLabelWrap()` and `RadioList::radioLabelWrap()` methods (@vjik)
- New #227, #228: Add ability to wrap items in checkbox and radio lists by using methods
  `CheckboxList::checkboxWrapTag()`, `CheckboxList::checkboxWrapAttributes()`, `CheckboxList::checkboxWrapClass()`,  
  `CheckboxList::addCheckboxWrapClass()`, `RadioList::radioWrapTag()`, `RadioList::radioWrapAttributes()`,
  `RadioList::radioWrapClass()` and `RadioList::addRadioWrapClass()` (@vjik)
- Enh #220: Add `non-empty-string` psalm type of `Html::generateId()` method result (@vjik)
- Enh #220: Add `non-empty-string|null` psalm type of `Tag::id()` method parameter (@vjik)
- Enh #222: Bump minimal PHP version to 8.1 and refactor (@vjik)

## 3.7.0 September 18, 2024

- New #218: Add methods `Script::nonce()` and `Script::getNonce()` for CSP (@Gerych1984, @vjik)
- Enh #219: Add backed enumeration value support to `Select` tag (@vjik)

## 3.6.0 August 23, 2024

- Enh #212: Throw `InvalidArgumentException` in `Html::renderAttribute()` when attribute name is empty or contains 
  forbidden symbols (@es-sayers, @vjik)
- Enh #214: Add `Stringable` and array values support to textarea tag (@vjik)
- Enh #217: Add backed enumeration value support to `CheckboxList` and `RadioList` widgets (@vjik)
- Bug #208: Fix output of `null` value attributes in `Html::renderTagAttributes()` (@es-sayers)

## 3.5.0 July 11, 2024

- New #192: Add class for tag `hr` and method `Html::hr()` (@abdulmannans)
- Enh #200: Add support for multiple elements in `aria-describedby` attribute (@arogachev)

## 3.4.0 December 26, 2023

- New #182: Add ability set attributes for label of items in widgets `CheckboxList` and `RadioList` (@vjik)

## 3.3.0 December 01, 2023

- New #173: Add class for tag `html` and method `Html::html()` (@dood-)
- Chg #179: Replace constant `PHP_EOL` to `"\n"` (@vjik)
- Enh #180: Don't add "class" attribute in `Html::addCssClass()` if passed array contains null classes only (@vjik)

## 3.2.0 November 21, 2023

- New #174: Add `$attributes` parameter to `Html::ul()` and `Html::ol()` (@AmolKumarGupta)
- Enh #176: Allow pass `null` as class to `Html::addCssClass()`, nulled classes will be ignored (@vjik)
- Bug #171: Fix loss of keys for named class in `Html::addCssClass()` when class in passed options is a string (@vjik)

## 3.1.0 January 17, 2023

- New #137: Add `$attributes` parameter to `Html::img()` (@alien-art)
- New #150: Add class for tag `small` and method `Html::small()` (@dood-)
- Enh #153: Add support of `yiisoft/arrays` version `^3.0` (@vjik)

## 3.0.0 November 06, 2022

- New #139: Add `loading()` method to `Img` tag (@jacobbudin)
- Chg #135: Raise `yiisoft/arrays` version to `^2.0` (@vjik)
- Chg #136: Remove `Tag::class()` and rename `Tag::replaceClass()` to `Tag::class()` (@vjik)
- Chg #140: Remove `Html::fileInput()` and `Input::file()`, rename `Input::fileControl()` to `Input::file()` (@vjik)
- Chg #141: `Tag` class: remove `attributes()` method and rename `replaceAttributes()` to `attributes()` (@vjik)
- Chg #141: `Range` class: remove `outputAttributes()` method and rename `replaceOutputAttributes()` 
  to `outputAttributes()` (@vjik)
- Chg #141: `File` class: remove `uncheckInputAttributes()` method and rename `replaceUncheckInputAttributes()` 
  to `uncheckInputAttributes()` (@vjik)
- Chg #141: `ButtonGroup` class: remove `buttonAttributes()` method and rename `replaceButtonAttributes()`
  to `buttonAttributes()` (@vjik)
- Chg #141: `CheckboxList`: remove `individualInputAttributes()` and `checkboxAttributes()` methods,
  rename `replaceIndividualInputAttributes()` to `individualInputAttributes()` and `replaceCheckboxAttributes()`
  to `checkboxAttributes()` (@vjik)
- Chg #141: `RadioList` class: remove `individualInputAttributes()` and `radioAttributes()` methods, 
  rename `replaceIndividualInputAttributes()` to `individualInputAttributes()` and `replaceRadioAttributes()` 
  to `radioAttributes()` (@vjik)
- Enh #133: Raise minimum PHP version to 8.0 and refactor code (@xepozz, @vjik)
- Enh #142: Make `NoEncodeStringableInterface` extend from `Stringable` interface (@vjik)
- Enh #143: Minor type hinting improvements (@vjik)
- Bug #143: Fix a typo in the message of exception that thrown on invalid buttons' data in `ButtonGroup` widget (@vjik)

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
