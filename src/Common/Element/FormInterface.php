<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Element;

use GrizzIt\Cli\Common\Element\Form\FieldInterface;
use GrizzIt\Cli\Common\Element\Form\FieldValidatorInterface;

interface FormInterface extends ElementInterface
{
    /**
     * Retrieves the input for the form.
     *
     * @return mixed[]
     */
    public function getInput(): array;

    /**
     * Adds a field to the form.
     *
     * @param string $name
     * @param FieldInterface $field
     * @param FieldValidatorInterface $validator
     *
     * @return void
     */
    public function addField(
        string $name,
        FieldInterface $field,
        FieldValidatorInterface $validator
    ): void;
}
