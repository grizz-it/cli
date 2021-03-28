<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Component\Io\Pointer;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\Pointer
 */
class PointerTest extends TestCase
{
    /**
     * @covers ::pointerUp
     * @covers ::__construct
     *
     * @return void
     */
    public function testPointerUp(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $subject = new Pointer($writer);

        $writer->expects(static::once())
            ->method('write');

        $subject->pointerUp(1);
    }

    /**
     * @covers ::pointerDown
     * @covers ::__construct
     *
     * @return void
     */
    public function testPointerDown(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $subject = new Pointer($writer);

        $writer->expects(static::once())
            ->method('write');

        $subject->pointerDown(1);
    }

    /**
     * @covers ::pointerLeft
     * @covers ::__construct
     *
     * @return void
     */
    public function testPointerLeft(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $subject = new Pointer($writer);

        $writer->expects(static::once())
            ->method('write');

        $subject->pointerLeft(1);
    }

    /**
     * @covers ::pointerRight
     * @covers ::__construct
     *
     * @return void
     */
    public function testPointerRight(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $subject = new Pointer($writer);

        $writer->expects(static::once())
            ->method('write');

        $subject->pointerRight(1);
    }
}
