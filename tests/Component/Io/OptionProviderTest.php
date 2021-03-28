<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Component\Io\OptionProvider;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\OptionProvider
 */
class OptionProviderTest extends TestCase
{
    /**
     * @covers ::__invoke
     * @covers ::__construct
     *
     * @return void
     */
    public function testInvoke(): void
    {
        $options = ['foo', 'bar', 'baz'];
        $subject = new OptionProvider($options);

        $this->assertEquals(['foo'], $subject->__invoke('fo'));
        $this->assertEquals($options, $subject->__invoke(''));
        $this->assertEquals([1 => 'bar', 2 => 'baz'], $subject->__invoke('b'));
    }
}
