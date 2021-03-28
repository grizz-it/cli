<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Theme\StyleEnum;
use GrizzIt\Cli\Component\Io\Styler;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\Styler
 */
class StylerTest extends TestCase
{
    /**
     * @covers ::style
     * @covers ::__construct
     *
     * @return void
     */
    public function testStyle(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $subject = new Styler($writer);

        $styles = $this->createMock(StyleEnum::class);
        $styles->expects(static::once())
            ->method('__toString')
            ->willReturn('THIS_IS_A_STYLE');

        $writer->expects(static::once())
            ->method('write')
            ->with($this->stringContains('THIS_IS_A_STYLE'));

        $subject->style($styles);
    }
}
