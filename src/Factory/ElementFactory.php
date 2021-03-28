<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Factory;

use GrizzIt\Task\Common\TaskListInterface;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Theme\ThemeInterface;
use GrizzIt\Cli\Component\Element\ListElement;
use GrizzIt\Cli\Component\Element\BlockElement;
use GrizzIt\Cli\Component\Element\ChainElement;
use GrizzIt\Cli\Component\Element\TableElement;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Component\Element\TextualElement;
use GrizzIt\Cli\Common\Factory\IoFactoryInterface;
use GrizzIt\Cli\Component\Element\ProgressElement;
use GrizzIt\Cli\Common\Factory\ElementFactoryInterface;
use GrizzIt\Cli\Component\Element\ExplainedListElement;

class ElementFactory implements ElementFactoryInterface
{
    /**
     * Contains the theme.
     *
     * @var ThemeInterface
     */
    private ThemeInterface $theme;

    /**
     * Contains the IO factory.
     *
     * @var IoFactoryInterface
     */
    private IoFactoryInterface $ioFactory;

    /**
     * Contains the used writer for the blocks.
     *
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * Constructor.
     *
     * @param ThemeInterface $theme
     * @param IoFactoryInterface $ioFactory
     * @param bool $useStderr
     */
    public function __construct(
        ThemeInterface $theme,
        IoFactoryInterface $ioFactory,
        bool $useStderr = false
    ) {
        $this->theme = $theme;
        $this->ioFactory = $ioFactory;
        $this->writer = $useStderr
            ? $ioFactory->createErrorWriter()
            : $ioFactory->createStandardWriter();
    }

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
    ): ElementInterface {
        return new TextualElement(
            $content,
            $this->writer,
            $newLine,
            $this->theme->getStyle($styleKey)
        );
    }

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
    ): ElementInterface {
        $table = new TableElement(
            $this->writer,
            $this->theme->getVariable($tableCharacters),
            $this->theme->getStyle($style),
            $this->theme->getStyle($boxStyle),
            $this->theme->getStyle($keyStyle)
        );

        foreach ($keys as $key) {
            $table->addKey($key);
        }

        $table->setItems($items);

        return $table;
    }

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
    ): ElementInterface {
        $list = new ListElement(
            $this->writer,
            $this->theme->getStyle($style)
        );

        foreach ($items as $item) {
            $list->addItem($item);
        }

        return $list;
    }

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
    ): ElementInterface {
        $list = new ExplainedListElement(
            $this->writer,
            $this->theme->getStyle($keyStyle),
            $this->theme->getStyle($descriptionStyle)
        );

        foreach ($items as $key => $description) {
            $list->addItem($description, ...explode('.', $key));
        }

        return $list;
    }

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
    ): ElementInterface {
        $block = new BlockElement(
            $content,
            $this->writer,
            $this->ioFactory->createTerminal(),
            $this->theme->getStyle($style)
        );

        $block->setPadding(
            ...$this->theme->getVariable($padding)
        );

        $block->setMargin(
            ...$this->theme->getVariable($margin)
        );

        return $block;
    }

    /**
     * Creates a new chain element.
     *
     * @param ElementInterface ...$elements
     *
     * @return ElementInterface
     */
    public function createChain(
        ElementInterface ...$elements
    ): ElementInterface {
        return new ChainElement(...$elements);
    }

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
    ): ElementInterface {
        return new ProgressElement(
            $this->writer,
            $this->theme->getVariable($progressCharacters),
            $this->ioFactory->createTerminal(),
            $taskList,
            $this->theme->getStyle($textStyle),
            $this->theme->getStyle($progressStyle)
        );
    }
}
