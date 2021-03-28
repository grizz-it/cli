<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Factory;

use GrizzIt\Cli\Component\Theme\Theme;
use GrizzIt\Cli\Common\Theme\StyleEnum;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Common\Theme\ThemeInterface;
use GrizzIt\Cli\Common\Factory\IoFactoryInterface;
use GrizzIt\Cli\Component\Theme\ConfigurableStyle;
use GrizzIt\Cli\Common\Factory\ThemeFactoryInterface;

class ThemeFactory implements ThemeFactoryInterface
{
    /**
     * Contains the IO factory.
     *
     * @var IoFactoryInterface
     */
    private IoFactoryInterface $ioFactory;

    /**
     * Constructor.
     *
     * @param IoFactoryInterface $ioFactory
     */
    public function __construct(IoFactoryInterface $ioFactory)
    {
        $this->ioFactory = $ioFactory;
    }

    /**
     * Creates a new style.
     *
     * @param StyleEnum ...$styles
     *
     * @return StyleInterface
     */
    public function createStyle(
        StyleEnum ...$styles
    ): StyleInterface {
        return new ConfigurableStyle(
            $this->ioFactory->createStyler(),
            ...$styles
        );
    }

    /**
     * Creates a new theme.
     *
     * @return ThemeInterface
     */
    public function createTheme(): ThemeInterface
    {
        return new Theme();
    }
}
