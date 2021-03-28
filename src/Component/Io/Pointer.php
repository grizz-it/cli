<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Io;

use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Io\PointerInterface;

class Pointer implements PointerInterface
{
    /**
     * Contains the writer to move the pointer.
     *
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * Constructor.
     *
     * @param WriterInterface $writer
     */
    public function __construct(WriterInterface $writer)
    {
        $this->writer = $writer;
    }

    /**
     * Moves the pointer up x line(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerUp(int $steps): void
    {
        if ($steps > 0) {
            $this->writer->write(sprintf("\033[%sA", $steps));
        }
    }

    /**
     * Moves the pointer down x line(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerDown(int $steps): void
    {
        if ($steps > 0) {
            $this->writer->write(sprintf("\033[%sB", $steps));
        }
    }

    /**
     * Moves the pointer left x column(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerLeft(int $steps): void
    {
        if ($steps > 0) {
            $this->writer->write(sprintf("\033[%sD", $steps));
        }
    }

    /**
     * Moves the pointer right x column(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerRight(int $steps): void
    {
        if ($steps > 0) {
            $this->writer->write(sprintf("\033[%sC", $steps));
        }
    }
}
