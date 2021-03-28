<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Component\Io\Reader;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\Reader
 */
class ReaderTest extends TestCase
{
    /**
     * @covers ::read
     * @covers ::__construct
     *
     * @return void
     */
    public function testRead(): void
    {
        $streamInput = 'php://temp';
        $writeStream = fopen($streamInput, 'w');
        fwrite($writeStream, 'foo');
        fclose($writeStream);
        $subject = new Reader($streamInput);

        $this->assertEquals('', $subject->read());
    }
}
