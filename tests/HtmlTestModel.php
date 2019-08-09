<?php
namespace Yiisoft\Html\Tests;

/**
 * @property string name
 * @property array types
 * @property string description
 */
class HtmlTestModel
{
    // TODO: should be constructor now?
    public function init(): void
    {
        foreach (['name', 'types', 'description', 'radio', 'checkbox'] as $attribute) {
            $this->defineAttribute($attribute);
        }
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'max' => 100],
            ['description', 'string', 'max' => 500],
            [['radio', 'checkbox'], 'boolean'],
        ];
    }

    public function customError(): string
    {
        return 'this is custom error message';
    }

    /**
     * Asserting two strings equality ignoring line endings.
     * @param string $expected
     * @param string $actual
     * @param string $message
     */
    private function assertSameWithoutLE(string $expected, string $actual, string $message = ''): void
    {
        $expected = str_replace("\r\n", "\n", $expected);
        $actual = str_replace("\r\n", "\n", $actual);
        $this->assertSame($expected, $actual, $message);
    }
}
