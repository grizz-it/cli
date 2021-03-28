<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element\Form;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Element\Form\FieldInterface;
use GrizzIt\Cli\Common\Io\ReaderInterface;
use GrizzIt\Cli\Component\Element\Form\ArrayField;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\Form\ArrayField
 */
class ArrayFieldTest extends TestCase
{
    /**
     * @covers ::render
     * @covers ::getInput
     * @covers ::__construct
     *
     * @return void
     */
    public function testField(): void
    {
        $reader = $this->createMock(ReaderInterface::class);
        $label = $this->createMock(ElementInterface::class);
        $confirmationField = $this->createMock(FieldInterface::class);
        $subject = new ArrayField($reader, $label, $confirmationField);

        $reader->expects(static::exactly(2))
            ->method('read')
            ->willReturnOnConsecutiveCalls('foo', 'bar');

        $label->expects(static::exactly(2))
            ->method('render');

        $confirmationField->expects(static::exactly(3))
            ->method('render');

        $confirmationField->expects(static::exactly(3))
            ->method('getInput')
            ->willReturnOnConsecutiveCalls('', 'y', 'n');

        $subject->render();

        $this->assertEquals(['foo', 'bar'], $subject->getInput());
    }
}
