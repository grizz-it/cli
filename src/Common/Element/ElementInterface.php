<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Element;

interface ElementInterface
{
    /**
     * Renders the element.
     *
     * @return void
     */
    public function render(): void;
}
