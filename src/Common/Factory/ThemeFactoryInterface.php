<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Factory;

use GrizzIt\Cli\Common\Theme\StyleEnum;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Common\Theme\ThemeInterface;

interface ThemeFactoryInterface
{
    /**
     * Creates a new style.
     *
     * @param StyleEnum ...$styles
     *
     * @return StyleInterface
     */
    public function createStyle(
        StyleEnum ...$styles
    ): StyleInterface;

    /**
     * Creates a new theme.
     *
     * @return ThemeInterface
     */
    public function createTheme(): ThemeInterface;
}
