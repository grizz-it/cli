<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Theme;

use GrizzIt\Cli\Common\Theme\StyleInterface;

class VoidStyle implements StyleInterface
{
    /**
     * Applies the style.
     *
     * @return void
     */
    public function apply(): void
    {
        return;
    }

    /**
     * Resets the style.
     *
     * @return void
     */
    public function reset(): void
    {
        return;
    }
}
