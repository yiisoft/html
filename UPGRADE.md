# Upgrading Instructions for Yii HTML

This file contains the upgrade notes. These notes highlight changes that could break your
application when you upgrade the package from one version to another.

> **Important!** The following upgrading instructions are cumulative. That is, if you want
> to upgrade from version A to version C and there is version B between A and C, you need
> to follow the instructions for both A and B.

## Upgrade from 3.x

- `Tag::id()` now throws `LogicException` when an empty string is passed. Check your code for places where you call
  `Tag::id()` and make sure you are not passing an empty string.
- HTML tag attributes are no longer sorted by `Html::renderTagAttributes()`. Previously, attributes were reordered
  according to a predefined priority list (`type`, `id`, `class`, `name`, `value`, etc.). Now attributes are rendered
  in the order they are set. If your code or tests depend on a specific attribute order in the rendered HTML, you need
  to update them.
