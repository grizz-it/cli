<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Factory;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\OptionProviderInterface;
use GrizzIt\Cli\Common\Io\PointerInterface;
use GrizzIt\Cli\Common\Io\ReaderInterface;
use GrizzIt\Cli\Common\Io\StylerInterface;
use GrizzIt\Cli\Common\Io\TerminalInterface;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Factory\IoFactory;

/**
 * @coversDefaultClass \GrizzIt\Cli\Factory\IoFactory
 */
class IoFactoryTest extends TestCase
{
    /**
     * @covers ::createErrorWriter
     *
     * @return void
     */
    public function testCreateErrorWriter(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            WriterInterface::class,
            $subject->createErrorWriter()
        );
    }

    /**
     * @covers ::createStandardWriter
     *
     * @return void
     */
    public function testCreateStandardWriter(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            WriterInterface::class,
            $subject->createStandardWriter()
        );
    }

    /**
     * @covers ::createPointer
     *
     * @return void
     */
    public function testCreatePointer(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            PointerInterface::class,
            $subject->createPointer()
        );
    }

    /**
     * @covers ::createStyler
     *
     * @return void
     */
    public function testCreateStyler(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            StylerInterface::class,
            $subject->createStyler()
        );
    }

    /**
     * @covers ::createStandardReader
     *
     * @return void
     */
    public function testCreateStandardReader(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createStandardReader()
        );
    }

    /**
     * @covers ::createHiddenReader
     *
     * @return void
     */
    public function testCreateHiddenReader(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createHiddenReader()
        );
    }

    /**
     * @covers ::createErrorReader
     *
     * @return void
     */
    public function testCreateErrorReader(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createErrorReader()
        );
    }

    /**
     * @covers ::createAutocompletingReader
     *
     * @return void
     */
    public function testCreateAutocompletingReader(): void
    {
        $subject = new IoFactory();
        $optionProvider = $this->createMock(OptionProviderInterface::class);

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createAutocompletingReader($optionProvider)
        );
    }

    /**
     * @covers ::createTerminal
     *
     * @return void
     */
    public function testCreateTerminal(): void
    {
        $subject = new IoFactory();

        $this->assertInstanceOf(
            TerminalInterface::class,
            $subject->createTerminal()
        );
    }

    /**
     * @covers ::setAllowReading
     * @covers ::createAutocompletingReader
     * @covers ::createHiddenReader
     * @covers ::createStandardReader
     * @covers ::createErrorReader
     *
     * @return void
     */
    public function testErrorReader(): void
    {
        $subject = new IoFactory();
        $allowReading = false;
        $subject->setAllowReading($allowReading);
        $optionProvider = $this->createMock(OptionProviderInterface::class);

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createAutocompletingReader($optionProvider)
        );

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createHiddenReader()
        );

        $this->assertInstanceOf(
            ReaderInterface::class,
            $subject->createStandardReader()
        );
    }
}
