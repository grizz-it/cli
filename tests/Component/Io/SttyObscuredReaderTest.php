<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\ReaderInterface;
use GrizzIt\Cli\Component\Io\SttyObscuredReader;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\SttyObscuredReader
 */
class SttyObscuredReaderTest extends TestCase
{
    /**
     * @covers ::read
     * @covers ::__construct
     *
     * @return void
     */
    public function testRead(): void
    {
        $reader = $this->createMock(ReaderInterface::class);
        $subject = new SttyObscuredReader($reader);

        $reader->expects(static::once())
            ->method('read')
            ->willReturn('foo');

        $this->assertEquals('foo', $subject->read());
    }
}
