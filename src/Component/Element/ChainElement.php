<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Element;

use GrizzIt\Cli\Common\Element\ElementInterface;

class ChainElement implements ElementInterface
{
    /**
     * The elements which need to be rendered.
     *
     * @var ElementInterface[]
     */
    private array $elements;

    /**
     * Constructor.
     *
     * @param ElementInterface ...$elements
     */
    public function __construct(
        ElementInterface ...$elements
    ) {
        $this->elements = $elements;
    }

    /**
     * Renders the element.
     *
     * @return void
     */
    public function render(): void
    {
        foreach ($this->elements as $element) {
            $element->render();
        }
    }
}
