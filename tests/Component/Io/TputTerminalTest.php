<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Component\Io\TputTerminal;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\TputTerminal
 */
class TputTerminalTest extends TestCase
{
    /**
     * @covers ::getHeight
     *
     * @return void
     */
    public function testGetHeight(): void
    {
        $subject = new TputTerminal();

        $this->assertIsInt($subject->getHeight());
    }

    /**
     * @covers ::getWidth
     *
     * @return void
     */
    public function testGetWidth(): void
    {
        $subject = new TputTerminal();

        $this->assertIsInt($subject->getWidth());
    }
}
