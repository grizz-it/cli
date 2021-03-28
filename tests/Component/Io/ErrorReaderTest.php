<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Component\Io\ErrorReader;
use GrizzIt\Cli\Exception\ReadingDisabledException;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\ErrorReader
 * @covers \GrizzIt\Cli\Exception\ReadingDisabledException
 */
class ErrorReaderTest extends TestCase
{
    /**
     * @covers ::read
     *
     * @return void
     */
    public function testRead(): void
    {
        $subject = new ErrorReader();

        $this->expectException(ReadingDisabledException::class);

        $subject->read();
    }
}
