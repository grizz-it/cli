<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Component\Io\Writer;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\Writer
 */
class WriterTest extends TestCase
{
    /**
     * @covers ::write
     * @covers ::__construct
     *
     * @return void
     */
    public function testWrite(): void
    {
        $streamInput = tempnam(sys_get_temp_dir(), 'testWrite');
        $readStream = fopen($streamInput, 'r');
        $subject = new Writer($streamInput);
        $input = 'foo';

        $subject->write($input);

        fseek($readStream, 0);
        $this->assertEquals($input, stream_get_contents($readStream));

        fclose($readStream);
        unlink($streamInput);
    }

    /**
     * @covers ::writeLine
     * @covers ::__construct
     *
     * @return void
     */
    public function testWriteLine(): void
    {
        $streamInput = tempnam(sys_get_temp_dir(), 'testWriteLine');
        $readStream = fopen($streamInput, 'r');
        $subject = new Writer($streamInput);
        $input = 'foo';

        $subject->writeLine($input);

        fseek($readStream, 0);
        $this->assertEquals($input . "\n", stream_get_contents($readStream));

        fclose($readStream);
        unlink($streamInput);
    }

    /**
     * @covers ::overWrite
     * @covers ::__construct
     *
     * @return void
     */
    public function testOverWrite(): void
    {
        $streamInput = tempnam(sys_get_temp_dir(), 'testOverWrite');
        $readStream = fopen($streamInput, 'r');
        $subject = new Writer($streamInput);
        $input = 'foo';

        $subject->overWrite($input);

        fseek($readStream, 0);
        $this->assertEquals($input . "\r", stream_get_contents($readStream));

        fclose($readStream);
        unlink($streamInput);
    }
}
