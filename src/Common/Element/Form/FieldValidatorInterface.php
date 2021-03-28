<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Element\Form;

use GrizzIt\Validator\Common\ValidatorInterface;
use GrizzIt\Cli\Common\Element\ElementInterface;

interface FieldValidatorInterface extends ValidatorInterface
{
    /**
     * Retrieves the error message for the field.-white
     *
     * @return ElementInterface
     */
    public function getError(): ElementInterface;
}
