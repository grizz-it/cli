<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Element;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Component\Element\TableElement;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Element\TableElement
 */
class TableElementTest extends TestCase
{
    /**
     * @covers ::render
     * @covers ::setItems
     * @covers ::addKey
     * @covers ::drawOuter
     * @covers ::drawNewLine
     * @covers ::calculateWidths
     * @covers ::__construct
     *
     * @return void
     */
    public function testRender(): void
    {
        $writer = $this->createMock(WriterInterface::class);
        $tableCharacters = [
            'corner' => [
                'top' => [
                    'left' => chr(218),
                    'right' => chr(191),
                ],
                'bottom' => [
                    'left' => chr(192),
                    'right' => chr(217),
                ],
            ],
            'cross' => [
                'left' => chr(195),
                'right' => chr(180),
                'top' => chr(194),
                'bottom' => chr(193),
                'center' => chr(197)
            ],
            'line' => [
                'horizontal' => chr(196),
                'vertical' => chr(179),
            ],
        ];

        $style = $this->createMock(StyleInterface::class);
        $boxStyle = $this->createMock(StyleInterface::class);
        $keyStyle = $this->createMock(StyleInterface::class);
        $subject = new TableElement($writer, $tableCharacters, $style, $boxStyle, $keyStyle);

        $items = [['foo' => 'bar'], ['foo' => 'baz']];
        $key = 'foo';

        $writer->expects(static::exactly(7))
            ->method('writeLine');

        $subject->setItems($items);
        $subject->addKey($key);

        $subject->render();
    }
}
