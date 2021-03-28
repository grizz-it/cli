<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Io;

use GrizzIt\Cli\Common\Io\WriterInterface;

class Writer implements WriterInterface
{
    /**
     * Contains the writer stream.
     *
     * @var resource
     */
    private $stream;

    /**
     * Constructor.
     *
     * @param string $streamInput
     * @param string $mode
     */
    public function __construct(
        string $streamInput = 'php://stdout',
        string $mode = 'w'
    ) {
        $this->stream = fopen($streamInput, $mode);
    }

    /**
     * Writes the output to the user.
     *
     * @param string $input
     *
     * @return void
     */
    public function write(string $input): void
    {
        fwrite($this->stream, $input);
        fflush($this->stream);
    }

    /**
     * Writes the output in a line to the user.
     *
     * @param string $input
     *
     * @return void
     */
    public function writeLine(string $input): void
    {
        $this->write($input . "\n");
    }

    /**
     * Writes a mutable line to the user.
     * The next writer will overwrite this line.
     *
     * @param string $input
     *
     * @return void
     */
    public function overWrite(string $input): void
    {
        $this->write($input . "\r");
    }
}
