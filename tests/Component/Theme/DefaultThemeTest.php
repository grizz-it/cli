<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Theme;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Generator\ThemeGeneratorInterface;
use GrizzIt\Cli\Common\Theme\ThemeInterface;
use GrizzIt\Cli\Component\Theme\DefaultTheme;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Theme\DefaultTheme
 */
class DefaultThemeTest extends TestCase
{
    /**
     * @covers ::getTheme
     * @covers ::__construct
     *
     * @return void
     */
    public function testGetTheme(): void
    {
        $themeGenerator = $this->createMock(ThemeGeneratorInterface::class);
        $subject = new DefaultTheme($themeGenerator);
        $this->assertInstanceOf(ThemeInterface::class, $subject->getTheme());
    }
}
