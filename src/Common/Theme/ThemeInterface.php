<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Theme;

interface ThemeInterface
{
    /**
     * Adds a style to a keyword.
     *
     * @param string $key
     * @param StyleInterface $style
     *
     * @return void
     */
    public function addStyle(string $key, StyleInterface $style): void;

    /**
     * Adds a variable to the theme.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addVariable(string $key, $value): void;

    /**
     * Retrieve a style based on the provided keyword.
     *
     * @param string $key
     *
     * @return StyleInterface
     */
    public function getStyle(string $key): StyleInterface;

    /**
     * Retrieves the variable of the theme.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getVariable(string $key);
}
