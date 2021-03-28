<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Io;

interface ReaderInterface
{
    /**
     * Reads the input and returns the users input.
     *
     * @return string
     */
    public function read(): string;
}
