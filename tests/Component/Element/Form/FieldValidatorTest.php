<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element\Form;

use GrizzIt\Validator\Common\ValidatorInterface;
use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Component\Element\Form\FieldValidator;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\Form\FieldValidator
 */
class FieldValidatorTest extends TestCase
{
    /**
     * @covers ::getError
     * @covers ::__construct
     *
     * @return void
     */
    public function testGetError(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $error = $this->createMock(ElementInterface::class);
        $subject = new FieldValidator($validator, $error);

        $this->assertEquals($error, $subject->getError());
    }

    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $validator = $this->createMock(ValidatorInterface::class);
        $error = $this->createMock(ElementInterface::class);
        $subject = new FieldValidator($validator, $error);

        $data = 'foo';

        $validator->expects(static::once())
            ->method('__invoke')
            ->with($data)
            ->willReturn(true);

        $this->assertEquals(true, $subject->__invoke($data));
    }
}
