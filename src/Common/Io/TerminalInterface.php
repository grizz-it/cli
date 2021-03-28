<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Io;

interface TerminalInterface
{
    /**
     * Retrieves the height of the current terminal.
     *
     * @return int
     */
    public function getHeight(): int;

    /**
     * Retrieves the wdith of the current terminal.
     *
     * @return int
     */
    public function getWidth(): int;
}
