<?php

declare(strict_types=1);

namespace Yiisoft\Html\Tag;

use Yiisoft\Html\Tag\Base\NormalTag;

/**
 * @link https://www.w3.org/TR/html52/tabular-data.html#the-table-element
 */
final class Table extends NormalTag
{
    private ?Caption $caption = null;
    private array $columnGroups = [];
    private array $columns = [];
    private ?Thead $header = null;
    private array $body = [];
    private array $rows = [];
    private ?Tfoot $footer = null;

    public function caption(?Caption $caption): self
    {
        $new = clone $this;
        $new->caption = $caption;
        return $new;
    }

    public function captionString(string $content, bool $encode = true): self
    {
        $caption = Caption::tag()->content($content);
        if (!$encode) {
            $caption = $caption->encode(false);
        }
        return $this->caption($caption);
    }

    /**
     * @param Colgroup ...$columnGroups One or more column groups ({@see Colgroup}).
     */
    public function columnGroups(Colgroup ...$columnGroups): self
    {
        $new = clone $this;
        $new->columnGroups = $columnGroups;
        return $new;
    }

    /**
     * @param Colgroup ...$columnGroups One or more column groups ({@see Colgroup}).
     */
    public function addColumnGroups(Colgroup ...$columnGroups): self
    {
        $new = clone $this;
        $new->columnGroups = array_merge($new->columnGroups, $columnGroups);
        return $new;
    }

    /**
     * @param Col ...$columns One or more columns ({@see Col}).
     */
    public function columns(Col ...$columns): self
    {
        $new = clone $this;
        $new->columns = $columns;
        return $new;
    }

    /**
     * @param Col ...$columns One or more columns ({@see Col}).
     */
    public function addColumns(Col ...$columns): self
    {
        $new = clone $this;
        $new->columns = array_merge($new->columns, $columns);
        return $new;
    }

    public function header(?Thead $header): self
    {
        $new = clone $this;
        $new->header = $header;
        return $new;
    }

    /**
     * @param Tbody ...$body One or more body ({@see Tbody}).
     */
    public function body(Tbody ...$body): self
    {
        $new = clone $this;
        $new->body = $body;
        return $new;
    }

    /**
     * @param Tbody ...$body One or more body ({@see Tbody}).
     */
    public function addBody(Tbody ...$body): self
    {
        $new = clone $this;
        $new->body = array_merge($new->body, $body);
        return $new;
    }

    /**
     * @param Tr ...$rows One or more rows ({@see Tr}).
     */
    public function rows(Tr ...$rows): self
    {
        $new = clone $this;
        $new->rows = $rows;
        return $new;
    }

    /**
     * @param Tr ...$rows One or more rows ({@see Tr}).
     */
    public function addRows(Tr ...$rows): self
    {
        $new = clone $this;
        $new->rows = array_merge($new->rows, $rows);
        return $new;
    }

    public function footer(?Tfoot $footer): self
    {
        $new = clone $this;
        $new->footer = $footer;
        return $new;
    }

    protected function generateContent(): string
    {
        $items = [];

        if ($this->caption !== null) {
            $items[] = $this->caption;
        }

        $items = array_merge(
            $items,
            $this->columnGroups,
            $this->columns,
        );

        if ($this->header !== null) {
            $items[] = $this->header;
        }

        $items = array_merge(
            $items,
            $this->body,
            $this->rows,
        );

        if ($this->footer !== null) {
            $items[] = $this->footer;
        }

        /** @var string[]|\Stringable[] $items */

        return $items
            ? "\n" . implode("\n", $items) . "\n"
            : '';
    }

    protected function getName(): string
    {
        return 'table';
    }
}
