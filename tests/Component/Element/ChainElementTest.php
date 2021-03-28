<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Component\Element\ChainElement;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\ChainElement
 */
class ChainElementTest extends TestCase
{
    /**
     * @covers ::render
     * @covers ::__construct
     *
     * @return void
     */
    public function testRender(): void
    {
        $elements = $this->createMock(ElementInterface::class);
        $subject = new ChainElement($elements);

        $elements->expects(static::once())
            ->method('render');

        $subject->render();
    }
}
