<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Component\Element\ExplainedListElement;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\ExplainedListElement
 */
class ExplainedListElementTest extends TestCase
{
    /**
     * @covers ::render
     * @covers ::addItem
     * @covers ::prepareArray
     * @covers ::__construct
     *
     * @return void
     */
    public function testRender(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $keyStyle = $this->createMock(StyleInterface::class);
        $descriptionStyle = $this->createMock(StyleInterface::class);
        $subject = new ExplainedListElement($writer, $keyStyle, $descriptionStyle);

        $description = 'foo';
        $keys = ['bar', 'baz'];

        $subject->addItem($description, ...$keys);
        // Validate that a similarly named key gets outputted as well.
        $subject->addItem($description, 'foo', 'baz');

        $writer->expects(static::exactly(4))
            ->method('writeLine');

        $subject->render();
    }
}
