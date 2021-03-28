<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Io;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Io\PointerInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Component\Io\OptionProvider;
use GrizzIt\Cli\Component\Io\SttyAutocompletingReader;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Io\SttyAutocompletingReader
 */
class SttyAutocompletingReaderTest extends TestCase
{
    /**
     * @covers ::read
     * @covers ::handleAddCharacter
     * @covers ::handleBackspace
     * @covers ::tabAutocomplete
     * @covers ::finishRecording
     * @covers ::handleEscapeSequences
     * @covers ::clearAutocomplete
     * @covers ::redrawInput
     * @covers ::moveSuggestion
     * @covers ::redrawSuggestion
     * @covers ::__construct
     *
     * @param string $input
     * @param string $expected
     *
     * @return void
     *
     * @dataProvider inputProvider
     */
    public function testRead(string $input, string $expected): void
    {
        $options = new OptionProvider(['foo', 'bar', 'baz']);
        $writer = $this->createMock(WriterInterface::class);
        $pointer = $this->createMock(PointerInterface::class);
        $autocompleteStyle = $this->createMock(StyleInterface::class);

        $streamInput = tempnam(sys_get_temp_dir(), 'testOverWrite');
        $writeStream = fopen($streamInput, 'w');
        fwrite($writeStream, $input);
        fclose($writeStream);

        $subject = new SttyAutocompletingReader(
            $options,
            $writer,
            $pointer,
            $autocompleteStyle,
            $streamInput,
            'r'
        );

        $this->assertEquals($expected, $subject->read());
    }

    /**
     * Provides the input for the test.
     *
     * @return array
     */
    public function inputProvider(): array
    {
        return [
            // Normal line read.
            [
                'foo',
                'foo'
            ],
            // 1 pointer left
            [
                "oo\033[Df",
                'ofo'
            ],
            // 2 pointer left, 1 right
            [
                "oo\033[D\033[D\033[Cf",
                'ofo'
            ],
            // 1 pointer right, autocomplete
            [
                "f\033[C",
                'foo'
            ],
            // 1 pointer up, tab autocomplete
            [
                "b\033[A" . chr(9),
                'baz'
            ],
            // 2 pointer down, tab autocomplete
            [
                "b\033[B\033[B" . chr(9),
                'bar'
            ],
            // 1 pointer down, tab autocomplete
            [
                "\033[B" . chr(9),
                'foo'
            ],
            // 1 pointer up, tab autocomplete
            [
                "\033[A" . chr(9),
                'baz'
            ],
            // 1 pointer up, no suggestion
            [
                "fa\033[A",
                'fa'
            ],
            // Home, delete
            [
                "aba\033[H\033[3",
                'ba'
            ],
            // Home, End, Backspace
            [
                "aba\033[H\033[F" . chr(127),
                'ab'
            ],
            // foo, Finish recording
            [
                "foo" . chr(10),
                'foo'
            ],
            // fa, Finish recording
            [
                "fa" . chr(10),
                'fa'
            ],
            // ba, Finish recording
            [
                "ba" . chr(10),
                'bar'
            ]
        ];
    }
}
