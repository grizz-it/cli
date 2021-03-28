<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Io;

use GrizzIt\Cli\Common\Io\TerminalInterface;

class SttyTerminal implements TerminalInterface
{
    /**
     * Retrieves the height of the current terminal.
     *
     * @return int
     */
    public function getHeight(): int
    {
        return explode(' ', trim(shell_exec('stty size')))[0];
    }

    /**
     * Retrieves the wdith of the current terminal.
     *
     * @return int
     */
    public function getWidth(): int
    {
        return explode(' ', trim(shell_exec('stty size')))[1];
    }
}
