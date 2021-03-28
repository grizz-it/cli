<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Component\Element\ListElement;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\ListElement
 */
class ListElementTest extends TestCase
{
    /**
     * @covers ::render
     * @covers ::addItem
     * @covers ::__construct
     *
     * @return void
     */
    public function testRender(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $style = $this->createMock(StyleInterface::class);
        $subject = new ListElement($writer, $style);

        $subject->addItem('foo');
        $subject->addItem('bar');

        $writer->expects(static::exactly(2))
            ->method('writeLine');

        $subject->render();
    }
}
