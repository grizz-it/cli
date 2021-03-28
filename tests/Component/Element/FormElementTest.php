<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Element\Form\FieldInterface;
use GrizzIt\Cli\Common\Element\Form\FieldValidatorInterface;
use GrizzIt\Cli\Component\Element\FormElement;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\FormElement
 */
class FormElementTest extends TestCase
{
    /**
     * @covers ::addField
     * @covers ::render
     * @covers ::getInput
     * @covers ::__construct
     *
     * @return void
     */
    public function testRender(): void
    {
        $description = $this->createMock(ElementInterface::class);
        $subject = new FormElement($description);

        $name = 'foo';
        $field = $this->createMock(FieldInterface::class);
        $validator = $this->createMock(FieldValidatorInterface::class);

        $subject->addField($name, $field, $validator);

        $field->expects(static::exactly(2))
            ->method('render');

        $validator->expects(static::exactly(2))
            ->method('__invoke')
            ->with('bar')
            ->willReturnOnConsecutiveCalls(false, true);

        $field->expects(static::exactly(2))
            ->method('getInput')
            ->willReturn('bar');

        $subject->render();

        $this->assertEquals(['foo' => 'bar'], $subject->getInput());
    }
}
