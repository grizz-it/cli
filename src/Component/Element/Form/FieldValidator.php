<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Element\Form;

use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Element\Form\FieldValidatorInterface;
use GrizzIt\Validator\Common\ValidatorInterface;

class FieldValidator implements FieldValidatorInterface
{
    /**
     * Contains the error which should be displayed when validation fails.
     *
     * @var ElementInterface
     */
    private ElementInterface $error;

    /**
     * Contains the validator which validates the field.
     *
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * Constructor.
     *
     * @param ValidatorInterface $validator
     * @param ElementInterface $error
     */
    public function __construct(
        ValidatorInterface $validator,
        ElementInterface $error
    ) {
        $this->validator = $validator;
        $this->error = $error;
    }

    /**
     * Retrieves the error message for the field.-white
     *
     * @return ElementInterface
     */
    public function getError(): ElementInterface
    {
        return $this->error;
    }

    /**
     * Validate the data against the validator.
     *
     * @param string|object|array $data
     *
     * @return bool
     */
    public function __invoke(mixed $data): bool
    {
        return $this->validator->__invoke($data);
    }
}
