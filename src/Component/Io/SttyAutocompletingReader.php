<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Component\Io;

use GrizzIt\Cli\Common\Io\ReaderInterface;
use GrizzIt\Cli\Common\Io\WriterInterface;
use GrizzIt\Cli\Common\Io\PointerInterface;
use GrizzIt\Cli\Common\Theme\StyleInterface;
use GrizzIt\Cli\Common\Io\OptionProviderInterface;

class SttyAutocompletingReader implements ReaderInterface
{
    /**
     * Contains the input for opening a stream.
     *
     * @var string
     */
    private string $streamInput;

    /**
     * Contains the mode for the stream.
     *
     * @var string
     */
    private string $mode;

    /**
     * Object to retrieve all options for a command.
     *
     * @var OptionProviderInterface
     */
    private OptionProviderInterface $options;

    /**
     * Contains the router used to manipulate the input display.
     *
     * @var WriterInterface
     */
    private WriterInterface $writer;

    /**
     * Contains the pointer.
     *
     * @var PointerInterface
     */
    private PointerInterface $pointer;

    /**
     * Contains the style for the autocompleter.
     *
     * @var StyleInterface
     */
    private StyleInterface $autocompleteStyle;

    /**
     * Contains the current pointer location.
     *
     * @var int
     */
    private int $pointerLocation = 0;

    /**
     * Determines the currently selected autocomplete option.
     *
     * @var int
     */
    private int $autocompleteSelector = -1;

    /**
     * Determines if autocompleting is active.
     *
     * @var bool
     */
    private bool $autocompletingActive = false;

    /**
     * Contains the current autocomplete suggestion.
     *
     * @var string
     */
    private string $autocompleteSuggestion = '';

    /**
     * Contains the remainder of which is shown in the autocomplete.
     *
     * @var string
     */
    private string $autocompleteRemainder = '';

    /**
     * Contains the current input.
     *
     * @var string
     */
    private string $input = '';

    /**
     * Contains all active autocomplete options.
     *
     * @var array
     */
    private array $currentOptions = [];

    /**
     * Constructor.
     *
     * @param OptionProviderInterface $options
     * @param WriterInterface $writer
     * @param PointerInterface $pointer
     * @param StyleInterface $autocompleteStyle
     * @param string $streamInput
     * @param string $mode
     */
    public function __construct(
        OptionProviderInterface $options,
        WriterInterface $writer,
        PointerInterface $pointer,
        StyleInterface $autocompleteStyle,
        string $streamInput = 'php://stdin',
        string $mode = 'rb'
    ) {
        $this->options = $options;
        $this->writer = $writer;
        $this->pointer = $pointer;
        $this->autocompleteStyle = $autocompleteStyle;
        $this->streamInput = $streamInput;
        $this->mode = $mode;
    }

    /**
     * Reads the input and returns the users input.
     *
     * @return string
     */
    public function read(): string
    {
        $sttyMode = shell_exec('stty -g');
        system('stty -icanon -echo');
        $inputStream = fopen($this->streamInput, $this->mode, false);

        $this->pointerLocation = 0;
        $this->clearAutocomplete();
        $this->input = '';
        $this->currentOptions = $this->options->__invoke($this->input);
        while (!feof($inputStream)) {
            $character = fread($inputStream, 1);
            // Interpret the escape sequence
            if ($character === "\033") {
                $this->handleEscapeSequences($inputStream);
                continue;
            }

            // Line feed, finish recording the input.
            if ($character === chr(10)) {
                $this->finishRecording();
                break;
            }
            // Backspace
            if ($character === chr(127)) {
                $this->handleBackspace();

                continue;
            } elseif ($character === chr(9)) {
                // Tab
                $this->tabAutocomplete();

                continue;
            }

            if (!empty($character)) {
                $this->handleAddCharacter($character);
                $this->currentOptions = $this->options->__invoke($this->input);

                if (!in_array($this->autocompleteSuggestion, $this->currentOptions)) {
                    if (count($this->currentOptions) === 0) {
                        $this->clearAutocomplete();
                        continue;
                    }

                    $this->clearAutocomplete();
                    $this->moveSuggestion(1);
                    $this->redrawSuggestion();
                }
            }
        }

        fclose($inputStream);
        shell_exec(sprintf('stty %s', $sttyMode));

        return $this->input;
    }

    /**
     * Handles writing a character to the input.
     *
     * @param string $character
     *
     * @return void
     */
    private function handleAddCharacter(string $character): void
    {
        // Write at the end.
        if ($this->pointerLocation === strlen($this->input)) {
            $this->input .= $character;
            $this->writer->write($character);
            $this->pointerLocation++;

            return;
        }

        // Write somewhere inside the stream.
        $this->input = substr(
            $this->input,
            0,
            $this->pointerLocation
        ) . $character . substr(
            $this->input,
            $this->pointerLocation
        );

        $this->redrawInput($this->pointerLocation + 1);
    }

    /**
     * Handles a backspace action.
     *
     * @return void
     */
    private function handleBackspace(): void
    {
        if ($this->pointerLocation !== 0) {
            $this->input = substr($this->input, 0, $this->pointerLocation - 1) .
            substr($this->input, $this->pointerLocation);
            $this->redrawInput($this->pointerLocation - 1);
        }

        $this->clearAutocomplete();
        $this->redrawSuggestion();
    }

    /**
     * Handles the internal functionality of tab autocomplete.
     *
     * @return void
     */
    private function tabAutocomplete(): void
    {
        if (count($this->currentOptions) === 1) {
            $this->input = array_pop($this->currentOptions);
            $this->redrawInput(strlen($this->input));
        } elseif ($this->autocompletingActive) {
            $this->input = $this->autocompleteSuggestion;
            $this->redrawInput(strlen($this->input));
            $this->clearAutocomplete();
            $this->redrawSuggestion();
        }
    }

    /**
     * Finish up recording the input.
     *
     * @return void
     */
    private function finishRecording(): void
    {
        if ($this->autocompletingActive === true) {
            $this->input = $this->autocompleteSuggestion;
            $this->clearAutocomplete();
            $this->redrawInput(strlen($this->input));
        }

        $this->writer->writeLine('');
    }

    /**
     * Handles the escape sequence characters.
     *
     * @param resource $inputStream
     *
     * @return void
     */
    private function handleEscapeSequences($inputStream): void
    {
        $character = fread($inputStream, 2);
        switch ($character) {
            // Left
            case '[D':
                if ($this->pointerLocation !== 0) {
                    $this->pointerLocation--;
                    $this->pointer->pointerLeft(1);
                }
                break;
            // Right
            case '[C':
                if ($this->pointerLocation !== strlen($this->input)) {
                    $this->pointerLocation++;
                    $this->pointer->pointerRight(1);
                } elseif ($this->autocompletingActive = true) {
                    $this->tabAutocomplete();
                }
                break;
            // Up
            case '[A':
                $this->moveSuggestion(-1);
                $this->redrawSuggestion();
                break;
            // Down
            case '[B':
                $this->moveSuggestion(1);
                $this->redrawSuggestion();
                break;
            // Delete
            case '[3':
                fread($inputStream, 1);
                $this->input = substr($this->input, 0, $this->pointerLocation) .
                substr($this->input, $this->pointerLocation + 1);
                $this->redrawInput($this->pointerLocation);
                $this->clearAutocomplete();
                break;
            // Home
            case '[H':
                $this->pointer->pointerLeft($this->pointerLocation);
                $this->pointerLocation = 0;
                break;
            // End
            case '[F':
                $inputLength = strlen($this->input);
                $this->pointer->pointerRight(
                    $inputLength - $this->pointerLocation
                );
                $this->pointerLocation = $inputLength;
                break;
        }
    }

    /**
     * Resets the autocompleter.
     *
     * @return void
     */
    private function clearAutocomplete(): void
    {
        $this->autocompletingActive = false;
        $this->autocompleteSelector = -1;
        $this->autocompleteSuggestion = '';
        $this->autocompleteRemainder = '';
    }

    /**
     * Redraws the input and sets the pointer.
     *
     * @param int $newPointerLocation
     *
     * @return void
     */
    private function redrawInput(int $newPointerLocation): void
    {
        // Reset the pointer to the beginning so we can redraw the input.
        $this->pointer->pointerLeft($this->pointerLocation);
        // Remove current input.
        $this->writer->write("\033[K");
        // Write new input.
        $this->writer->write($this->input);
        // Set pointer to new location.
        $this->pointerLocation = $newPointerLocation;
        // Back up to the desired point.
        $this->pointer->pointerLeft(
            strlen($this->input) - $this->pointerLocation
        );
    }

    /**
     * Moves the suggestion cursor.
     *
     * @param int $move
     *
     * @return void
     */
    private function moveSuggestion(int $move): void
    {
        if (count($this->currentOptions) > 0) {
            $optionKeys = array_keys($this->currentOptions);
            $this->autocompletingActive = true;
            // Negative number check.
            if (abs($move) !== $move) {
                if ($this->autocompleteSelector <= 0) {
                    // Go to the last suggestion
                    $this->autocompleteSelector = count($optionKeys) - 1;
                } else {
                    $this->autocompleteSelector--;
                }
            } else {
                if (
                    $this->autocompleteSelector === -1
                    || $this->autocompleteSelector === count($optionKeys) - 1
                ) {
                    // Go to the first suggestion
                    $this->autocompleteSelector = 0;
                } else {
                    $this->autocompleteSelector++;
                }
            }

            $this->autocompleteSuggestion = $this->currentOptions[
                $optionKeys[$this->autocompleteSelector]
            ];

            return;
        }

        $this->clearAutocomplete();
    }

    /**
     * Draws the suggestion for the user.
     *
     * @return void
     */
    private function redrawSuggestion(): void
    {
        $move = strlen($this->input) - $this->pointerLocation;
        $this->pointer->pointerRight($move);
        $this->writer->write("\033[K");

        if ($this->autocompletingActive) {
            $this->autocompleteStyle->apply();
            $this->autocompleteRemainder = preg_replace(
                sprintf('/^%s/', preg_quote($this->input)),
                '',
                $this->autocompleteSuggestion
            );

            $move = $move + strlen($this->autocompleteRemainder);
            $this->writer->write($this->autocompleteRemainder);
            $this->autocompleteStyle->reset();
        }

        $this->pointer->pointerLeft($move);
    }
}
