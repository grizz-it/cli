<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Element;

use GrizzIt\Cli\Common\Element\FormInterface;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Element\Form\FieldInterface;
use GrizzIt\Cli\Common\Element\Form\FieldValidatorInterface;

class FormElement implements FormInterface
{
    /**
     * Contains the elements to describe the form.
     *
     * @var ElementInterface[]
     */
    private array $description;

    /**
     * Contains the form data.
     *
     * @var mixed[]
     */
    private array $form = [];

    /**
     * Contains the fields of the form.
     *
     * @var FieldInterface[]
     */
    private array $fields = [];

    /**
     * Constructor.
     *
     * @param ElementInterface ...$description
     */
    public function __construct(ElementInterface ...$description)
    {
        $this->description = $description;
    }

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
    ): void {
        $this->fields[$name] = [$field, $validator];
    }

    /**
     * Processes the form and stores the input.
     *
     * @return void
     */
    public function render(): void
    {
        foreach ($this->description as $element) {
            $element->render();
        }

        $form = [];
        foreach ($this->fields as $name => $fieldValidator) {
            /** @var FieldInterface $field */
            /** @var FieldValidatorInterface $validator */
            [$field, $validator] = $fieldValidator;
            $field->render();
            $result = $field->getInput();
            while (!$validator->__invoke($result)) {
                $validator->getError()->render();
                $field->render();
                $result = $field->getInput();
            }

            $form[$name] = $result;
        }

        $this->form = $form;
    }

    /**
     * Retrieves the input provided in the form.
     *
     * @return mixed[]
     */
    public function getInput(): array
    {
        return $this->form;
    }
}
