<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Io;

use GrizzIt\Cli\Common\Theme\StyleEnum;

interface StylerInterface
{
    /**
     * Styles the output.
     *
     * @param StyleEnum ...$styles
     *
     * @return void
     */
    public function style(StyleEnum ...$styles): void;
}
