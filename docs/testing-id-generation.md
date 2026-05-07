# Testing ID Generation

`Html::generateId()` produces IDs that include an `hrtime(true)` timestamp, making them unique across
requests but non-deterministic in tests. The file `src/test-functions.php` provides helpers that make
generated IDs predictable during testing.

## Setup

Include the file once before running tests:

```php
require_once 'vendor/yiisoft/html/src/test-functions.php';
```

## Functions

### `\Yiisoft\Html\IdGenerator\disableSeed()`

Disables the `hrtime()` seed: IDs become short and deterministic — `i1`, `i2`, `test1`, etc.
Call this in test setup to get predictable, hardcodable IDs.

### `\Yiisoft\Html\IdGenerator\enableSeed()`

Re-enables the `hrtime()` seed, reverting to the default behaviour where IDs include a timestamp.
Call this in test teardown to restore normal operation.

### `\Yiisoft\Html\IdGenerator\reset()`

Resets the counter to zero without changing the current seed mode. Useful when you need
a fresh counter mid-test while the seed is disabled.

## Usage in PHPUnit

### Bootstrap

To load the file automatically for the entire test suite, add it to your bootstrap file.

In `phpunit.xml`:

```xml
<phpunit bootstrap="tests/bootstrap.php">
```

In `tests/bootstrap.php`:

```php
require_once 'vendor/yiisoft/html/src/test-functions.php';
```

### Global disableSeed with per-test reset

If all tests in the suite need deterministic IDs, call `disableSeed()` once in the bootstrap
and then call `reset()` at the start of each test that relies on specific ID values:

In `tests/bootstrap.php`:

```php
require_once 'vendor/yiisoft/html/src/test-functions.php';

\Yiisoft\Html\IdGenerator\disableSeed();
```

In the test class:

```php
final class MyTest extends TestCase
{
    public function testRendersLabel(): void
    {
        \Yiisoft\Html\IdGenerator\reset();

        $this->assertSame('<label for="i1">Name</label>', ...);
    }
}
```

### `setUp()` and `tearDown()`

Useful when only one test class (or a few) needs deterministic IDs while the rest of the suite
uses the default `hrtime()` behaviour — for example, when adding ID assertions to an existing
project without touching the global bootstrap.

Call `disableSeed()` and `reset()` in `setUp()` so every test starts with deterministic IDs
from `i1`. Add `enableSeed()` in `tearDown()` to restore the default behaviour after the class
finishes:

```php
final class MyTest extends TestCase
{
    protected function setUp(): void
    {
        \Yiisoft\Html\IdGenerator\disableSeed();
        \Yiisoft\Html\IdGenerator\reset();
    }

    protected function tearDown(): void
    {
        \Yiisoft\Html\IdGenerator\enableSeed();
    }

    public function testRendersLabel(): void
    {
        // IDs are now i1, i2, … — safe to hardcode in assertions
        $this->assertSame('<label for="i1">Name</label>', ...);
    }
}
```
