<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Factory;

use PHPUnit\Framework\TestCase;
use GrizzIt\Task\Common\TaskListInterface;
use GrizzIt\Cli\Common\Element\ElementInterface;
use GrizzIt\Cli\Common\Factory\IoFactoryInterface;
use GrizzIt\Cli\Common\Theme\ThemeInterface;
use GrizzIt\Cli\Factory\ElementFactory;

/**
 * @coversDefaultClass \GrizzIt\Cli\Factory\ElementFactory
 */
class ElementFactoryTest extends TestCase
{
    /**
     * @covers ::createText
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateText(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = false;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);

        $content = 'foo';
        $newLine = false;
        $styleKey = 'label';

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createText($content, $newLine, $styleKey)
        );
    }

    /**
     * @covers ::createTable
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateTable(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = true;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);

        $keys = ['foo'];
        $items = [['foo' => 'bar']];

        $theme->expects(static::once())
            ->method('getVariable')
            ->with('table-characters')
            ->willReturn([]);

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createTable(
                $keys,
                $items
            )
        );
    }

    /**
     * @covers ::createList
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateList(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = false;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);
        $items = ['foo'];
        $style = 'foo';

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createList($items, $style)
        );
    }

    /**
     * @covers ::createExplainedList
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateExplainedList(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = false;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);

        $items = ['foo.bar' => 'description'];

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createExplainedList($items)
        );
    }

    /**
     * @covers ::createBlock
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateBlock(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = false;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);

        $content = 'foo';

        $theme->expects(static::exactly(2))
            ->method('getVariable')
            ->withConsecutive(['block-padding'], ['block-margin'])
            ->willReturn([1, 2, 3, 4]);

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createBlock($content)
        );
    }

    /**
     * @covers ::createChain
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateChain(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = false;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);

        $elements = $this->createMock(ElementInterface::class);

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createChain($elements)
        );
    }

    /**
     * @covers ::createProgressBar
     * @covers ::__construct
     *
     * @return void
     */
    public function testCreateProgressBar(): void
    {
        $theme = $this->createMock(ThemeInterface::class);
        $ioFactory = $this->createMock(IoFactoryInterface::class);
        $useStderr = false;
        $subject = new ElementFactory($theme, $ioFactory, $useStderr);

        $taskList = $this->createMock(TaskListInterface::class);

        $theme->expects(static::once())
            ->method('getVariable')
            ->with('progress-characters')
            ->willReturn([]);

        $this->assertInstanceOf(
            ElementInterface::class,
            $subject->createProgressBar($taskList)
        );
    }
}
