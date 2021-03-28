<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Factory;

use GrizzIt\Cli\Common\Io\ReaderInterface;
use GrizzIt\Cli\Common\Io\StylerInterface;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Io\PointerInterface;
use GrizzIt\Cli\Common\Io\TerminalInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Common\Io\OptionProviderInterface;

interface IoFactoryInterface
{
    /**
     * Creates an error writer.
     *
     * @return WriterInterface
     */
    public function createErrorWriter(): WriterInterface;

    /**
     * Creates a standard writer.
     *
     * @return WriterInterface
     */
    public function createStandardWriter(): WriterInterface;

    /**
     * Creates a pointer.
     *
     * @return PointerInterface
     */
    public function createPointer(): PointerInterface;

    /**
     * Creates a styler.
     *
     * @return StylerInterface
     */
    public function createStyler(): StylerInterface;

    /**
     * Creates a standard reader.
     *
     * @return ReaderInterface
     */
    public function createStandardReader(): ReaderInterface;

    /**
     * Creates a hidden reader.
     *
     * @return ReaderInterface
     */
    public function createHiddenReader(): ReaderInterface;

    /**
     * Creates an error reader.
     *
     * @return ReaderInterface
     */
    public function createErrorReader(): ReaderInterface;

    /**
     * Creates a autocompleting reader.
     *
     * @param OptionProviderInterface $optionProvider
     * @param StyleInterface $style
     *
     * @return ReaderInterface
     */
    public function createAutocompletingReader(
        OptionProviderInterface $optionProvider,
        StyleInterface $style = null
    ): ReaderInterface;

    /**
     * Creates a terminal.
     *
     * @return TerminalInterface
     */
    public function createTerminal(): TerminalInterface;

    /**
     * Turns all readers into error readers.
     *
     * @param bool $allowReading
     *
     * @return void
     */
    public function setAllowReading(bool $allowReading = true): void;
}
