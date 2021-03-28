<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\TerminalInterface;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Component\Element\BlockElement;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\BlockElement
 */
class BlockElementTest extends TestCase
{
    /**
     * @covers ::render
     * @covers ::setPadding
     * @covers ::setMargin
     * @covers ::calculateOffsets
     * @covers ::__construct
     *
     * @return void
     */
    public function testRender(): void
    {
        $content = 'foo';
        $writer = $this->createMock(WriterInterface::class);
        $terminal = $this->createMock(TerminalInterface::class);
        $style = $this->createMock(StyleInterface::class);
        $subject = new BlockElement($content, $writer, $terminal, $style);

        $top = 1;
        $right = 2;
        $bottom = 3;
        $left = 4;

        $subject->setMargin($top, $right, $bottom, $left);
        $subject->setPadding($top, $right, $bottom, $left);

        $terminal->expects(static::once())
            ->method('getWidth')
            ->willReturn(100);

        $subject->render();
    }

    /**
     * @covers ::render
     * @covers ::setPadding
     * @covers ::setMargin
     * @covers ::calculateOffsets
     * @covers ::__construct
     *
     * @return void
     */
    public function testElementLimitedWidth(): void
    {
        $content = 'foo';
        $writer = $this->createMock(WriterInterface::class);
        $terminal = $this->createMock(TerminalInterface::class);
        $style = $this->createMock(StyleInterface::class);
        $subject = new BlockElement($content, $writer, $terminal, $style);

        $top = 1;
        $right = 2;
        $bottom = 3;
        $left = 4;

        $subject->setMargin($top, $right, $bottom, $left);
        $subject->setPadding($top, $right, $bottom, $left);

        $terminal->expects(static::once())
            ->method('getWidth')
            ->willReturn(5);

        $subject->render();
    }
}
