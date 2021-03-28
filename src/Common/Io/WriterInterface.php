<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Io;

interface WriterInterface
{
    /**
     * Writes the output to the user.
     *
     * @param string $input
     *
     * @return void
     */
    public function write(string $input): void;

    /**
     * Writes the output in a line to the user.
     *
     * @param string $input
     *
     * @return void
     */
    public function writeLine(string $input): void;

    /**
     * Writes a mutable line to the user.
     * The next writer will overwrite this line.
     *
     * @param string $input
     *
     * @return void
     */
    public function overWrite(string $input): void;
}
