<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Element;

use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Component\Theme\VoidStyle;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Common\Element\ElementInterface;

class TableElement implements ElementInterface
{
    /**
     * Contains the writer to display the table.
     *
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * Contains the keys for the table.
     *
     * @var string[]
     */
    private array $keys = [];

    /**
     * Contains the entries for the table.
     *
     * @var string[][]
     */
    private array $items = [];

    /**
     * Contains a list of characters used to render the table.
     *
     * @var array
     */
    private array $tableCharacters;

    /**
     * Contains the style of the content of the table.
     *
     * @var StyleInterface
     */
    private StyleInterface $style;

    /**
     * Contains the style of the borders.
     *
     * @var StyleInterface
     */
    private StyleInterface $boxStyle;

    /**
     * Contains the style for the keys of the table.
     *
     * @var StyleInterface
     */
    private StyleInterface $keyStyle;

    /**
     * Constructor.
     *
     * @param WriterInterface $writer
     * @param array $tableCharacters
     * @param StyleInterface $style
     * @param StyleInterface $boxStyle
     * @param StyleInterface $keyStyle
     */
    public function __construct(
        WriterInterface $writer,
        array $tableCharacters,
        StyleInterface $style = null,
        StyleInterface $boxStyle = null,
        StyleInterface $keyStyle = null
    ) {
        $this->style = $style ?? new VoidStyle();
        $this->boxStyle = $boxStyle ?? new VoidStyle();
        $this->keyStyle = $keyStyle ?? new VoidStyle();
        $this->writer = $writer;
        $this->tableCharacters = $tableCharacters;
    }

    /**
     * Renders the element.
     *
     * @return void
     */
    public function render(): void
    {
        $widths = $this->calculateWidths();

        $horizontalLine = [];
        foreach ($this->keys as $key) {
            $horizontalLine[] = str_repeat(
                $this->tableCharacters['line']['horizontal'],
                $widths[$key]
            );
        }

        $this->drawOuter($horizontalLine, 'top');

        $middleLine = implode(
            $this->tableCharacters['cross']['center'],
            $horizontalLine
        );

        // Draw the keys.
        $this->boxStyle->apply();
        $this->writer->write($this->tableCharacters['line']['vertical']);
        $this->boxStyle->reset();

        foreach ($this->keys as $key) {
            $this->keyStyle->apply();
            $this->writer->write(
                str_pad($key, $widths[$key], ' ')
            );
            $this->keyStyle->reset();

            $this->boxStyle->apply();
            $this->writer->write($this->tableCharacters['line']['vertical']);
            $this->boxStyle->reset();
        }

        $this->writer->writeLine('');

        // Draw the items.
        foreach ($this->items as $item) {
            $this->drawNewLine($middleLine);

            foreach ($this->keys as $key) {
                $this->style->apply();
                $this->writer->write(
                    str_pad($item[$key], $widths[$key], ' ')
                );
                $this->style->reset();

                $this->boxStyle->apply();
                $this->writer->write($this->tableCharacters['line']['vertical']);
                $this->boxStyle->reset();
            }
            $this->writer->writeLine('');
        }

        $this->drawOuter($horizontalLine, 'bottom');
    }

    /**
     * Draws the top of the table.
     *
     * @param string[] $horizontalLine
     * @param string $outer
     *
     * @return void
     */
    private function drawOuter(
        array $horizontalLine,
        string $outer = 'top'
    ): void {
        $this->boxStyle->apply();
        $this->writer->write(
            $this->tableCharacters['corner'][$outer]['left']
        );

        $this->writer->write(
            implode(
                $this->tableCharacters['cross'][$outer],
                $horizontalLine
            ) . $this->tableCharacters['corner'][$outer]['right']
        );

        $this->boxStyle->reset();
        $this->writer->writeLine('');
    }

    /**
     * Draws a new line.
     *
     * @param string $middleLine
     *
     * @return void
     */
    private function drawNewLine(string $middleLine): void
    {
        $this->boxStyle->apply();
        $this->writer->write(
            $this->tableCharacters['cross']['left'] .
            $middleLine .
            $this->tableCharacters['cross']['right']
        );
        $this->boxStyle->reset();
        $this->writer->writeLine('');

        $this->boxStyle->apply();
        $this->writer->write($this->tableCharacters['line']['vertical']);
        $this->boxStyle->reset();
    }

    /**
     * Calculates the widths for each key.
     *
     * @return array
     */
    private function calculateWidths(): array
    {
        $widths = [];
        foreach ($this->keys as $key) {
            $widths[$key] = max(
                array_merge(
                    array_map(
                        'strlen',
                        array_column($this->items, $key)
                    ),
                    [strlen($key)]
                )
            );
        }

        return $widths;
    }

    /**
     * Sets the items on the table element.
     *
     * @param array $items
     *
     * @return void
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * Adds a key to read from the content.
     *
     * @param string $key
     *
     * @return void
     */
    public function addKey(string $key): void
    {
        $this->keys[] = $key;
    }
}
