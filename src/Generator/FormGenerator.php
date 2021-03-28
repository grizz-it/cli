<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Generator;

use GrizzIt\Validator\Common\ValidatorInterface;
use GrizzIt\Validator\Component\Chain\OrValidator;
use GrizzIt\Validator\Component\Chain\AndValidator;
use GrizzIt\Validator\Component\Logical\AlwaysValidator;
use GrizzIt\Validator\Component\Logical\EnumValidator;
use GrizzIt\Validator\Component\Iterable\MinItemsValidator;
use GrizzIt\Validator\Component\Textual\MinLengthValidator;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Element\Form\FieldValidatorInterface;
use GrizzIt\Cli\Component\Io\OptionProvider;
use GrizzIt\Cli\Common\Element\FormInterface;
use GrizzIt\Cli\Exception\NotInitializedException;
use GrizzIt\Cli\Common\Factory\FormFactoryInterface;
use GrizzIt\Cli\Component\Element\Form\FieldValidator;
use GrizzIt\Cli\Common\Factory\ElementFactoryInterface;
use GrizzIt\Cli\Common\Generator\FormGeneratorInterface;

class FormGenerator implements FormGeneratorInterface
{
    /**
     * Contains the theme factory.
     *
     * @var FormFactoryInterface
     */
    private FormFactoryInterface $formFactory;

    /**
     * Contains the element factory.
     *
     * @var ElementFactoryInterface
     */
    private ElementFactoryInterface $elementFactory;

    /**
     * Contains the current theme.
     *
     * @var FormInterface|null
     */
    private ?FormInterface $form = null;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $formFactory
     * @param ElementFactoryInterface $elementFactory
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        ElementFactoryInterface $elementFactory
    ) {
        $this->formFactory = $formFactory;
        $this->elementFactory = $elementFactory;
    }

    /**
     * Creates a new theme.
     *
     * @param string $title
     * @param string $description
     *
     * @return FormGeneratorInterface
     */
    public function init(
        string $title,
        string $description = ''
    ): FormGeneratorInterface {
        $title = [$this->elementFactory->createText($title, true, 'title')];
        if (!empty($description)) {
            $title[] = $this->elementFactory->createText(
                $description,
                true,
                'text'
            );
        }

        $this->form = $this->formFactory->createForm(...$title);

        return $this;
    }

    /**
     * Reinitializes a form.
     *
     * @param FormInterface $form
     *
     * @return FormGeneratorInterface
     */
    public function reinit(FormInterface $form): FormGeneratorInterface
    {
        $this->form = $form;

        return $this;
    }

    /**
     * Adds an open field to the form.
     *
     * @param string $name
     * @param bool $required
     * @param string $errorMessage
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FormGeneratorInterface
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    public function addOpenField(
        string $name,
        bool $required = true,
        string $errorMessage = 'This is a required field.',
        ValidatorInterface ...$additionalValidators
    ): FormGeneratorInterface {
        $this->preAddCheck();
        $title = sprintf(
            '%s%s: ',
            $this->convertKeyToLabel($name),
            $required ? '*' : ''
        );

        $label = $this->elementFactory->createText($title, false, 'label');
        $validator = $this->createValidator(
            $required,
            $errorMessage,
            ...$additionalValidators
        );

        $field = $this->formFactory->createField($label);

        $this->form->addField($name, $field, $validator);

        return $this;
    }

    /**
     * Adds a hidden field to the form.
     *
     * @param string $name
     * @param bool $required
     * @param string $errorMessage
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FormGeneratorInterface
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    public function addHiddenField(
        string $name,
        bool $required = true,
        string $errorMessage = 'This is a required field.',
        ValidatorInterface ...$additionalValidators
    ): FormGeneratorInterface {
        $this->preAddCheck();
        $title = sprintf(
            '%s(hidden)%s: ',
            $this->convertKeyToLabel($name),
            $required ? '*' : ''
        );

        $label = $this->elementFactory->createText($title, false, 'label');
        $validator = $this->createValidator(
            $required,
            $errorMessage,
            ...$additionalValidators
        );

        $field = $this->formFactory->createObscuredField($label);

        $this->form->addField($name, $field, $validator);

        return $this;
    }

    /**
     * Adds an autocompleting (options) field to the form.
     *
     * @param string $name
     * @param array $options
     * @param bool $required
     * @param string $errorMessageRequired
     * @param string $errorMessageEnum
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FormGeneratorInterface
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    public function addAutocompletingField(
        string $name,
        array $options,
        bool $required = true,
        string $errorMessageRequired = 'This is a required field.',
        string $errorMessageEnum = 'The value must be in the options list.',
        ValidatorInterface ...$additionalValidators
    ): FormGeneratorInterface {
        $this->preAddCheck();
        $title = sprintf(
            '%s%s: ',
            $this->convertKeyToLabel($name),
            $required ? '*' : ''
        );

        $label = $this->elementFactory->createChain(
            $this->elementFactory->createList($options),
            $this->elementFactory->createText($title, false, 'label')
        );

        $additionalValidators[] = new EnumValidator($options);
        $validator = $this->createValidator(
            $required,
            ($required ? $errorMessageRequired . "\n" : '') . $errorMessageEnum,
            ...$additionalValidators
        );

        $field = $this->formFactory->createAutocompletingField(
            $label,
            new OptionProvider($options)
        );

        $this->form->addField($name, $field, $validator);

        return $this;
    }

    /**
     * Adds an open array field to the form.
     *
     * @param string $name
     * @param bool $required
     * @param string $additionalMessage
     * @param string $errorMessage
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FormGeneratorInterface
     *
     * @throws NotInitializedException When the form is not initalized.
     */
    public function addOpenArrayField(
        string $name,
        bool $required = true,
        string $additionalMessage = 'Add another value?',
        string $errorMessage = 'This is a required field.',
        ValidatorInterface ...$additionalValidators
    ): FormGeneratorInterface {
        $this->preAddCheck();
        $title = sprintf(
            '%s%s: ',
            $this->convertKeyToLabel($name),
            $required ? '*' : ''
        );

        $label = $this->elementFactory->createText($title, false, 'label');
        $additionalLabel = $this->createAdditionalMessage($additionalMessage);
        $validator = $this->createValidator(
            $required,
            $errorMessage,
            ...$additionalValidators
        );

        $field = $this->formFactory->createArrayField($label, $additionalLabel);

        $this->form->addField($name, $field, $validator);

        return $this;
    }

    /**
     * Adds a hidden field to the form.
     *
     * @param string $name
     * @param bool $required
     * @param string $additionalMessage
     * @param string $errorMessage
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FormGeneratorInterface
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    public function addHiddenArrayField(
        string $name,
        bool $required = true,
        string $additionalMessage = 'Add another value?',
        string $errorMessage = 'This is a required field.',
        ValidatorInterface ...$additionalValidators
    ): FormGeneratorInterface {
        $this->preAddCheck();
        $title = $this->convertKeyToLabel($name) . sprintf(
            '(hidden)%s: ',
            $required ? '*' : ''
        );

        $label = $this->elementFactory->createText($title, false, 'label');
        $additionalLabel = $this->createAdditionalMessage($additionalMessage);
        $validator = $this->createValidator(
            $required,
            $errorMessage,
            ...$additionalValidators
        );

        $field = $this->formFactory->createObscuredArrayField(
            $label,
            $additionalLabel
        );

        $this->form->addField($name, $field, $validator);

        return $this;
    }

    /**
     * Adds an autocompleting (options) field to the form.
     *
     * @param string $name
     * @param array $options
     * @param bool $required
     * @param string $additionalMessage
     * @param string $errorMessageRequired
     * @param string $errorMessageEnum
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FormGeneratorInterface
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    public function addAutocompletingArrayField(
        string $name,
        array $options,
        bool $required = true,
        string $additionalMessage = 'Add another value?',
        string $errorMessageRequired = 'This is a required field.',
        string $errorMessageEnum = 'The value must be in the options list.',
        ValidatorInterface ...$additionalValidators
    ): FormGeneratorInterface {
        $this->preAddCheck();
        $title = $this->convertKeyToLabel($name) . sprintf(
            '%s: ',
            $required ? '*' : ''
        );

        $label = $this->elementFactory->createChain(
            $this->elementFactory->createList($options),
            $this->elementFactory->createText($title, false, 'label')
        );

        $additionalLabel = $this->createAdditionalMessage($additionalMessage);
        $additionalValidators[] = new EnumValidator($options);
        $validator = $this->createValidator(
            $required,
            ($required ? $errorMessageRequired . "\n" : '') . $errorMessageEnum,
            ...$additionalValidators
        );

        $field = $this->formFactory->createAutocompletingArrayField(
            $label,
            $additionalLabel,
            new OptionProvider($options)
        );

        $this->form->addField($name, $field, $validator);

        return $this;
    }

    /**
     * Executes a check before elements can be added.
     *
     * @return void
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    private function preAddCheck(): void
    {
        if ($this->form === null) {
            throw new NotInitializedException(self::class, 'init', 'form');
        }
    }

    /**
     * Creates the additional message label.
     *
     * @param string $additionalMessage
     *
     * @return ElementInterface
     */
    private function createAdditionalMessage(
        string $additionalMessage
    ): ElementInterface {
        return $this->elementFactory->createText(
            sprintf(
                '%s (y/n): ',
                $additionalMessage
            ),
            false,
            'label'
        );
    }

    /**
     * Creates a validator for the field.
     *
     * @param bool $required
     * @param string $errorMessage
     * @param ValidatorInterface ...$additionalValidators
     *
     * @return FieldValidatorInterface
     */
    private function createValidator(
        bool $required,
        string $errorMessage,
        ValidatorInterface ...$additionalValidators
    ): FieldValidatorInterface {
        $validator = $required ? new OrValidator(
            new MinLengthValidator(1),
            new MinItemsValidator(1)
        ) : new AlwaysValidator(true);

        return new FieldValidator(
            new AndValidator($validator, ...$additionalValidators),
            $this->elementFactory->createBlock($errorMessage, 'error-block')
        );
    }

    /**
     * Converts the key to a label.
     *
     * @param string $key
     *
     * @return string
     */
    private function convertKeyToLabel(string $key): string
    {
        return ucwords(str_replace('_', ' ', $key));
    }

    /**
     * Retrieves the current generating form.
     *
     * @return FormInterface
     *
     * @throws NotInitializedException When the form is not initialized.
     */
    public function getForm(): FormInterface
    {
        $this->preAddCheck();
        $form = $this->form;
        $this->form = null;

        return $form;
    }
}
