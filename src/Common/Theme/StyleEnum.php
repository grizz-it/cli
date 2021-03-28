<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Theme;

use GrizzIt\Enum\Enum;

/**
 * @method static StyleEnum RESET_ALL()
 * @method static StyleEnum BOLD()
 * @method static StyleEnum DIM()
 * @method static StyleEnum CURSIVE()
 * @method static StyleEnum UNDERLINE()
 * @method static StyleEnum BLINK()
 * @method static StyleEnum BLINK_2()
 * @method static StyleEnum INVERSE()
 * @method static StyleEnum HIDDEN()
 * @method static StyleEnum STRIKETHROUGH()
 * @method static StyleEnum DOULBE_UNDERLINE()
 * @method static StyleEnum TEXT_BLACK()
 * @method static StyleEnum TEXT_RED()
 * @method static StyleEnum TEXT_GREEN()
 * @method static StyleEnum TEXT_YELLOW()
 * @method static StyleEnum TEXT_BLUE()
 * @method static StyleEnum TEXT_MAGENTA()
 * @method static StyleEnum TEXT_CYAN()
 * @method static StyleEnum TEXT_GRAY()
 * @method static StyleEnum TEXT_BRIGHT_BLACK()
 * @method static StyleEnum TEXT_BRIGHT_RED()
 * @method static StyleEnum TEXT_BRIGHT_GREEN()
 * @method static StyleEnum TEXT_BRIGHT_YELLOW()
 * @method static StyleEnum TEXT_BRIGHT_BLUE()
 * @method static StyleEnum TEXT_BRIGHT_MAGENTA()
 * @method static StyleEnum TEXT_BRIGHT_CYAN()
 * @method static StyleEnum TEXT_BRIGHT_GRAY()
 * @method static StyleEnum BACKGROUND_BLACK()
 * @method static StyleEnum BACKGROUND_RED()
 * @method static StyleEnum BACKGROUND_GREEN()
 * @method static StyleEnum BACKGROUND_YELLOW()
 * @method static StyleEnum BACKGROUND_BLUE()
 * @method static StyleEnum BACKGROUND_MAGENTA()
 * @method static StyleEnum BACKGROUND_CYAN()
 * @method static StyleEnum BACKGROUND_GRAY()
 * @method static StyleEnum BACKGROUND_BRIGHT_BLACK()
 * @method static StyleEnum BACKGROUND_BRIGHT_RED()
 * @method static StyleEnum BACKGROUND_BRIGHT_GREEN()
 * @method static StyleEnum BACKGROUND_BRIGHT_YELLOW()
 * @method static StyleEnum BACKGROUND_BRIGHT_BLUE()
 * @method static StyleEnum BACKGROUND_BRIGHT_MAGENTA()
 * @method static StyleEnum BACKGROUND_BRIGHT_CYAN()
 * @method static StyleEnum BACKGROUND_BRIGHT_GRAY()
 */
class StyleEnum extends Enum
{
    // Attributes
    public const RESET_ALL = '0';
    public const BOLD = '1';
    public const DIM = '2';
    public const CURSIVE = '3';
    public const UNDERLINE = '4';
    public const BLINK = '5';
    public const BLINK_2 = '6';
    public const INVERSE = '7';
    public const HIDDEN = '8';
    public const STRIKETHROUGH = '9';
    public const DOUBLE_UNDERLINE = '21';

    // Text colors
    public const TEXT_BLACK = '30';
    public const TEXT_RED = '31';
    public const TEXT_GREEN = '32';
    public const TEXT_YELLOW = '33';
    public const TEXT_BLUE = '34';
    public const TEXT_MAGENTA = '35';
    public const TEXT_CYAN = '36';
    public const TEXT_GRAY = '37';

    public const TEXT_BRIGHT_BLACK = '90';
    public const TEXT_BRIGHT_RED = '91';
    public const TEXT_BRIGHT_GREEN = '92';
    public const TEXT_BRIGHT_YELLOW = '93';
    public const TEXT_BRIGHT_BLUE = '94';
    public const TEXT_BRIGHT_MAGENTA = '95';
    public const TEXT_BRIGHT_CYAN = '96';
    public const TEXT_BRIGHT_GRAY = '97';

    // Background colors
    public const BACKGROUND_BLACK = '40';
    public const BACKGROUND_RED = '41';
    public const BACKGROUND_GREEN = '42';
    public const BACKGROUND_YELLOW = '43';
    public const BACKGROUND_BLUE = '44';
    public const BACKGROUND_MAGENTA = '45';
    public const BACKGROUND_CYAN = '46';
    public const BACKGROUND_GRAY = '47';

    public const BACKGROUND_BRIGHT_BLACK = '100';
    public const BACKGROUND_BRIGHT_RED = '101';
    public const BACKGROUND_BRIGHT_GREEN = '102';
    public const BACKGROUND_BRIGHT_YELLOW = '103';
    public const BACKGROUND_BRIGHT_BLUE = '104';
    public const BACKGROUND_BRIGHT_MAGENTA = '105';
    public const BACKGROUND_BRIGHT_CYAN = '106';
    public const BACKGROUND_BRIGHT_GRAY = '107';
}
