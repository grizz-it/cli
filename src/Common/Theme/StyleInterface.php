<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Theme;

interface StyleInterface
{
    /**
     * Applies the style.
     *
     * @return void
     */
    public function apply(): void;

    /**
     * Resets the style.
     *
     * @return void
     */
    public function reset(): void;
}
