<?php

namespace Yiisoft\Html\Tests;

/**
 * @property string name
 * @property array types
 * @property string description
 */
class HtmlTestModel
{
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
}
