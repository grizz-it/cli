<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Generator;

use GrizzIt\Cli\Common\Theme\StyleEnum;
use GrizzIt\Cli\Common\Theme\ThemeInterface;

interface ThemeGeneratorInterface
{
    /**
     * Creates a new theme.
     *
     * @return ThemeGeneratorInterface
     */
    public function init(): ThemeGeneratorInterface;

    /**
     * Reinitializes theme in generator.
     *
     * @param ThemeInterface $theme
     *
     * @return ThemeGeneratorInterface
     */
    public function reinit(ThemeInterface $theme): ThemeGeneratorInterface;

    /**
     * Adds a new style to the current theme.
     *
     * @param string $key
     * @param StyleEnum ...$styles
     *
     * @return ThemeGeneratorInterface
     */
    public function addStyle(
        string $key,
        StyleEnum ...$styles
    ): ThemeGeneratorInterface;

    /**
     * Adds a variable to the theme.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return ThemeGeneratorInterface
     */
    public function addVariable(
        string $key,
        $value
    ): ThemeGeneratorInterface;

    /**
     * Retrieves the current generating theme.
     *
     * @return ThemeInterface
     */
    public function getTheme(): ThemeInterface;
}
