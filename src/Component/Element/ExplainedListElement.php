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

class ExplainedListElement implements ElementInterface
{
    /**
     * Contains the writer to display the list.
     *
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * Contains the style of the key.
     *
     * @var StyleInterface
     */
    private StyleInterface $keyStyle;

    /**
     * Contains the style of the description.
     *
     * @var StyleInterface
     */
    private StyleInterface $descriptionStyle;

    /**
     * Contains the entries for the list.
     *
     * @var string[]
     */
    private array $items = ['items' => []];

    /**
     * Constructor.
     *
     * @param WriterInterface $writer
     * @param StyleInterface $keyStyle
     * @param StyleInterface $descriptionStyle
     */
    public function __construct(
        WriterInterface $writer,
        StyleInterface $keyStyle = null,
        StyleInterface $descriptionStyle = null
    ) {
        $this->writer = $writer;
        $this->descriptionStyle = $descriptionStyle ?? new VoidStyle();
        $this->keyStyle = $keyStyle ?? new VoidStyle();
    }

    /**
     * Renders the element.
     *
     * @return void
     */
    public function render(): void
    {
        $items = $this->prepareArray(
            $this->items['items']
        );

        $columnWidth = max(
            array_map('strlen', array_column($items, 'key'))
        ) + 4;

        foreach ($items as $item) {
            $spaceless = ltrim($item['key']);
            $spaces = str_replace($spaceless, '', $item['key']);
            $this->writer->write($spaces);
            $this->keyStyle->apply();
            $this->writer->write($spaceless);
            $this->keyStyle->reset();
            $this->writer->write(
                str_repeat(
                    ' ',
                    $columnWidth - strlen($item['key'])
                )
            );
            $this->descriptionStyle->apply();
            $this->writer->write($item['description']);
            $this->descriptionStyle->reset();
            $this->writer->writeLine('');
        }
    }

    /**
     * Prepares the array for rendering.
     *
     * @param array $items
     * @param int $depth
     *
     * @return array
     */
    private function prepareArray(
        array $items,
        int $depth = 0
    ): array {
        $return = [];
        ksort($items);

        foreach ($items as $key => $item) {
            $return[] = [
                'description' => $item['description'],
                'key' => str_repeat('  ', $depth) . $key
            ];

            if (
                isset($item['items'])
                && !empty($item['items'])
            ) {
                $return = array_merge(
                    $return,
                    $this->prepareArray(
                        $item['items'],
                        $depth + 1
                    )
                );
            }
        }

        return $return;
    }

    /**
     * Adds an item to the list.
     *
     * @param string $description
     * @param string[] $keys
     *
     * @return void
     */
    public function addItem(string $description, string ...$keys): void
    {
        $items = &$this->items;
        foreach ($keys as $key) {
            if (!isset($items['items'][$key])) {
                $items['items'][$key] = ['items' => [], 'description' => ''];
            }

            $items = &$items['items'][$key];
        }

        $items['description'] = $description;
    }
}
