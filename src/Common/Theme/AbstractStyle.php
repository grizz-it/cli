<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Theme;

use GrizzIt\Cli\Common\Io\StylerInterface;

abstract class AbstractStyle implements StyleInterface
{
    /**
     * Contains the styler to apply the style.
     *
     * @var StylerInterface
     */
    private $styler;

    /**
     * Constructor.
     *
     * @param StylerInterface $styler
     */
    public function __construct(StylerInterface $styler)
    {
        $this->styler = $styler;
    }

    /**
     * Returns the internal styler.
     *
     * @return StylerInterface
     */
    public function getStyler(): StylerInterface
    {
        return $this->styler;
    }

    /**
     * Resets the style.
     *
     * @return void
     */
    public function reset(): void
    {
        $this->styler->style(StyleEnum::RESET_ALL());
    }
}
