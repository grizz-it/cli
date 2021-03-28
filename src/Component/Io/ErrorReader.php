<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Io;

use GrizzIt\Cli\Common\Io\ReaderInterface;
use GrizzIt\Cli\Exception\ReadingDisabledException;

class ErrorReader implements ReaderInterface
{
    /**
     * Reads the input and returns the users input.
     *
     * @return string
     *
     * @throws ReadingDisabledException Always.
     */
    public function read(): string
    {
        throw new ReadingDisabledException();
    }
}
