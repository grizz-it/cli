<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Io;

use GrizzIt\Cli\Common\Io\ReaderInterface;

class Reader implements ReaderInterface
{
    /**
     * Contains the input for opening a stream.
     *
     * @var string
     */
    private string $streamInput;

    /**
     * Contains the mode for the stream.
     *
     * @var string
     */
    private string $mode;

    /**
     * Constructor.
     *
     * @param string $streamInput
     * @param string $mode
     */
    public function __construct(
        string $streamInput = 'php://stdin',
        string $mode = 'rb'
    ) {
        $this->streamInput = $streamInput;
        $this->mode = $mode;
    }

    /**
     * Reads the input and returns the users input.
     *
     * @return string
     */
    public function read(): string
    {
        $inputStream = fopen($this->streamInput, $this->mode, false);
        $input = rtrim(fgets($inputStream), chr(10));
        fclose($inputStream);

        return $input;
    }
}
