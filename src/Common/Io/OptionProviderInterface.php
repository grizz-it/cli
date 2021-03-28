<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Io;

interface OptionProviderInterface
{
    /**
     * Retrieves the options based on the input.
     *
     * @param string $input
     *
     * @return array
     */
    public function __invoke(string $input): array;
}
