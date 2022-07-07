<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tests\Widget;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tests\Support\AssertTrait;
use Yiisoft\Html\Widget\ButtonGroup;

final class ButtonGroupTest extends TestCase
{
    use AssertTrait;

    public function testBase(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::resetButton('Reset Data'),
                Html::submitButton('Send'),
            );

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="reset">Reset Data</button>
            <button type="submit">Send</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function testWithoutButtons(): void
    {
        $this->assertSame('', ButtonGroup::create()->render());
    }

    public function testButtonsData(): void
    {
        $widget = ButtonGroup::create()
            ->buttonsData([
                ['Reset Data', 'type' => 'reset'],
                ['Send >', 'type' => 'submit', 'class' => 'primary'],
            ]);

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="reset">Reset Data</button>
            <button type="submit" class="primary">Send &gt;</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function dataButtonsDataEncode(): array
    {
        return [
            [
                '<button type="button">Go &gt;</button>',
                'Go >',
                true,
            ],
            [
                '<button type="button"><b>Go</b></button>',
                '<b>Go</b>',
                false,
            ],
        ];
    }

    /**
     * @dataProvider dataButtonsDataEncode
     */
    public function testButtonsDataEncode(string $expected, string $label, ?bool $encode): void
    {
        $widget = ButtonGroup::create()
            ->buttonsData(
                [
                    [$label],
                ],
                $encode
            )
            ->withoutContainer();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $widget->render());
    }

    public function testInvalidButtonsData(): void
    {
        $widget = ButtonGroup::create();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid buttons data. A data row must be array with label as first element ' .
            'and additional name-value pairs as attrbiutes of button.'
        );
        $widget->buttonsData([[42]]);
    }

    public function testWithoutContainer(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::resetButton('Reset Data'),
                Html::submitButton('Send'),
            )
            ->withoutContainer();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <button type="reset">Reset Data</button>
            <button type="submit">Send</button>
            HTML,
            $widget->render(),
        );
    }

    public function dataContainerTag(): array
    {
        return [
            [
                '<button type="button">Show</button>',
                null,
            ],
            [
                '<button type="button">Show</button>',
                '',
            ],
            [
                <<<HTML
                <section>
                <button type="button">Show</button>
                </section>
                HTML,
                'section',
            ],
        ];
    }

    /**
     * @dataProvider dataContainerTag
     */
    public function testContainerTag(string $expected, ?string $tagName): void
    {
        $widget = ButtonGroup::create()
            ->buttons(Html::button('Show'))
            ->containerTag($tagName);

        $this->assertStringContainsStringIgnoringLineEndings($expected, $widget->render());
    }

    public function testBaseContainerAttributes(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(Html::button('Show'))
            ->containerAttributes(['id' => 'actions']);

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div id="actions">
            <button type="button">Show</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function testButtonAttributes(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show'),
                Html::button('Hide'),
            )
            ->buttonAttributes(['class' => 'base']);

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="button" class="base">Show</button>
            <button type="button" class="base">Hide</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function testMergeButtonAttributes(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show'),
                Html::button('Hide'),
            )
            ->buttonAttributes(['class' => 'base'])
            ->buttonAttributes(['data-key' => '42'])
            ->disabled();

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="button" class="base" disabled data-key="42">Show</button>
            <button type="button" class="base" disabled data-key="42">Hide</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function testUnionButtonAttributes(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show')->replaceClass('red'),
                Html::button('Hide'),
            )
            ->buttonAttributes(['class' => 'base']);

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="button" class="red">Show</button>
            <button type="button" class="base">Hide</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function testReplaceButtonAttributes(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show'),
                Html::button('Hide'),
            )
            ->disabled()
            ->replaceButtonAttributes(['class' => 'base']);

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="button" class="base">Show</button>
            <button type="button" class="base">Hide</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function dataDisabled(): array
    {
        return [
            [
                <<<HTML
                <button type="button">Show</button>
                <button type="button">Hide</button>
                HTML,
                null,
            ],
            [
                <<<HTML
                <button type="button">Show</button>
                <button type="button">Hide</button>
                HTML,
                false,
            ],
            [
                <<<HTML
                <button type="button" disabled>Show</button>
                <button type="button" disabled>Hide</button>
                HTML,
                true,
            ],
        ];
    }

    /**
     * @dataProvider dataDisabled
     */
    public function testDisabled(string $expected, ?bool $disabled): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show'),
                Html::button('Hide'),
            )
            ->disabled($disabled)
            ->withoutContainer();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $widget->render());
    }

    public function dataForm(): array
    {
        return [
            [
                <<<HTML
                <button type="button">Show</button>
                <button type="button">Hide</button>
                HTML,
                null,
            ],
            [
                <<<HTML
                <button type="button" form="CreatePost">Show</button>
                <button type="button" form="CreatePost">Hide</button>
                HTML,
                'CreatePost',
            ],
        ];
    }

    /**
     * @dataProvider dataForm
     */
    public function testForm($expected, ?string $id): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show'),
                Html::button('Hide'),
            )
            ->form($id)
            ->withoutContainer();

        $this->assertStringContainsStringIgnoringLineEndings($expected, $widget->render());
    }

    public function testSeparator(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::button('Show'),
                Html::button('Hide'),
            )
            ->separator('-');

        $this->assertStringContainsStringIgnoringLineEndings(
            <<<HTML
            <div>
            <button type="button">Show</button>-<button type="button">Hide</button>
            </div>
            HTML,
            $widget->render(),
        );
    }

    public function testStringable(): void
    {
        $widget = ButtonGroup::create()
            ->buttons(
                Html::resetButton('Reset Data'),
                Html::submitButton('Send'),
            );

        $this->assertStringContainsStringIgnoringLineEndings($widget->render(), (string) $widget);
    }

    public function testImmutability(): void
    {
        $widget = ButtonGroup::create();

        $this->assertNotSame($widget, $widget->withoutContainer());
        $this->assertNotSame($widget, $widget->containerTag(null));
        $this->assertNotSame($widget, $widget->containerAttributes([]));
        $this->assertNotSame($widget, $widget->buttons());
        $this->assertNotSame($widget, $widget->buttonsData([]));
        $this->assertNotSame($widget, $widget->buttonAttributes([]));
        $this->assertNotSame($widget, $widget->replaceButtonAttributes([]));
        $this->assertNotSame($widget, $widget->disabled());
        $this->assertNotSame($widget, $widget->form(null));
        $this->assertNotSame($widget, $widget->separator(''));
    }
}
