<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Exception;

use Exception;

class ReadingDisabledException extends Exception
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'Can not read input, reading has been disabled.'
        );
    }
}
