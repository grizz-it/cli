<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Element\Form;

use GrizzIt\Cli\Common\Element\ElementInterface;

interface FieldInterface extends ElementInterface
{
    /**
     * Retrieves the input for the field.
     *
     * @return mixed
     */
    public function getInput();
}
