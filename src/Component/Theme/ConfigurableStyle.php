<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Theme;

use GrizzIt\Cli\Common\Theme\StyleEnum;
use GrizzIt\Cli\Common\Io\StylerInterface;
use GrizzIt\Cli\Common\Theme\AbstractStyle;

class ConfigurableStyle extends AbstractStyle
{
    /**
     * Contains the applicators to create the style.
     *
     * @var StyleEnum[]
     */
    private array $styles;

    /**
     * Constructor.
     *
     * @param StylerInterface $styler
     * @param StyleEnum ...$styles
     */
    public function __construct(StylerInterface $styler, StyleEnum ...$styles)
    {
        parent::__construct($styler);
        $this->styles = $styles;
    }

    /**
     * Applies the style.
     *
     * @return void
     */
    public function apply(): void
    {
        $this->getStyler()->style(...$this->styles);
    }
}
