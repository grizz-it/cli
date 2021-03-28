<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Factory;

use GrizzIt\Task\Common\TaskListInterface;
use GrizzIt\Cli\Common\Element\ElementInterface;

interface ElementFactoryInterface
{
    /**
     * Creates a new text element.
     *
     * @param string $content
     * @param bool $newLine
     * @param string $styleKey
     *
     * @return ElementInterface
     */
    public function createText(
        string $content,
        bool $newLine = true,
        string $styleKey = 'text'
    ): ElementInterface;

    /**
     * Creates a new table.
     *
     * @param string[] $keys
     * @param array $items
     * @param string $tableCharacters
     * @param string $style
     * @param string $boxStyle
     * @param string $keyStyle
     *
     * @return ElementInterface
     */
    public function createTable(
        array $keys,
        array $items,
        string $tableCharacters = 'table-characters',
        string $style = 'table-style',
        string $boxStyle = 'table-box-style',
        string $keyStyle = 'table-key-style'
    ): ElementInterface;

    /**
     * Creates a list.
     *
     * @param array $items
     * @param string $style
     *
     * @return ElementInterface
     */
    public function createList(
        array $items,
        string $style = 'list'
    ): ElementInterface;

    /**
     * Creates a new explained list.
     *
     * @param array $items
     * @param string $keyStyle
     * @param string $descriptionStyle
     *
     * @return ElementInterface
     */
    public function createExplainedList(
        array $items,
        string $keyStyle = 'explained-list-key',
        string $descriptionStyle = 'explained-list-description'
    ): ElementInterface;

    /**
     * Creates a new block.
     *
     * @param string $content
     * @param string $style
     * @param string $padding
     * @param string $margin
     *
     * @return ElementInterface
     */
    public function createBlock(
        string $content,
        string $style = 'block',
        string $padding = 'block-padding',
        string $margin = 'block-margin'
    ): ElementInterface;

    /**
     * Creates a new chain element.
     *
     * @param ElementInterface ...$elements
     *
     * @return ElementInterface
     */
    public function createChain(
        ElementInterface ...$elements
    ): ElementInterface;

    /**
     * Creates a progress bar.
     *
     * @param TaskListInterface $taskList
     * @param string $progressCharacters
     * @param string $textStyle
     * @param string $progressStyle
     *
     * @return ElementInterface
     */
    public function createProgressBar(
        TaskListInterface $taskList,
        string $progressCharacters = 'progress-characters',
        string $textStyle = 'progress-text',
        string $progressStyle = 'progress-bar'
    ): ElementInterface;
}
