<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Factory;

use GrizzIt\Cli\Common\Element\Form\FieldInterface;
use GrizzIt\Cli\Common\Element\FormInterface;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Io\OptionProviderInterface;

interface FormFactoryInterface
{
    /**
     * Creates a new form.
     *
     * @param ElementInterface ...$description
     *
     * @return FormInterface
     */
    public function createForm(
        ElementInterface ...$description
    ): FormInterface;

    /**
     * Creates a new field.
     *
     * @param ElementInterface $label
     *
     * @return FieldInterface
     */
    public function createField(
        ElementInterface $label
    ): FieldInterface;

    /**
     * Creates a new obscured field.
     *
     * @param ElementInterface $label
     *
     * @return FieldInterface
     */
    public function createObscuredField(
        ElementInterface $label
    ): FieldInterface;

    /**
     * Creates a new autocompleting field.
     *
     * @param ElementInterface $label
     * @param OptionProviderInterface $optionProvider
     * @param string $style
     *
     * @return FieldInterface
     */
    public function createAutocompletingField(
        ElementInterface $label,
        OptionProviderInterface $optionProvider,
        string $style = 'autocomplete'
    ): FieldInterface;

    /**
     * Creates a new array field.
     *
     * @param ElementInterface $label
     * @param ElementInterface $extraLabel
     *
     * @return FieldInterface
     */
    public function createArrayField(
        ElementInterface $label,
        ElementInterface $extraLabel
    ): FieldInterface;

    /**
     * Creates a new obscured array field.
     *
     * @param ElementInterface $label
     * @param ElementInterface $extraLabel
     *
     * @return FieldInterface
     */
    public function createObscuredArrayField(
        ElementInterface $label,
        ElementInterface $extraLabel
    ): FieldInterface;

    /**
     * Creates a new autocompleting array field.
     *
     * @param ElementInterface $label
     * @param ElementInterface $extraLabel
     * @param OptionProviderInterface $optionProvider
     * @param string $style
     *
     * @return FieldInterface
     */
    public function createAutocompletingArrayField(
        ElementInterface $label,
        ElementInterface $extraLabel,
        OptionProviderInterface $optionProvider,
        string $style = 'autocomplete'
    ): FieldInterface;
}
