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

class ListElement implements ElementInterface
{
    /**
     * Contains the writer to display the list.
     *
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * Contains the style for the list.
     *
     * @var StyleInterface
     */
    private StyleInterface $style;

    /**
     * Contains the items for the list.
     *
     * @var string[]
     */
    private array $items = [];

    /**
     * Constructor.
     *
     * @param WriterInterface $writer
     * @param StyleInterface $style
     */
    public function __construct(
        WriterInterface $writer,
        StyleInterface $style = null
    ) {
        $this->writer = $writer;
        $this->style = $style ?? new VoidStyle();
    }

    /**
     * Renders the element.
     *
     * @return void
     */
    public function render(): void
    {
        foreach ($this->items as $item) {
            $this->style->apply();
            $this->writer->write($item);
            $this->style->reset();
            $this->writer->writeLine('');
        }
    }

    /**
     * Adds an item to the list.
     *
     * @param string $item
     *
     * @return void
     */
    public function addItem(string $item): void
    {
        $this->items[] = $item;
    }
}
