<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Tests\Component\Theme;

use PHPUnit\Framework\TestCase;
use GrizzIt\Cli\Common\Io\StylerInterface;
use GrizzIt\Cli\Common\Theme\StyleEnum;
use GrizzIt\Cli\Component\Theme\ConfigurableStyle;

/**
 * @coversDefaultClass \GrizzIt\Cli\Component\Theme\ConfigurableStyle
 * @covers \GrizzIt\Cli\Common\Theme\AbstractStyle
 */
class ConfigurableStyleTest extends TestCase
{
    /**
     * @covers ::apply
     * @covers ::reset
     * @covers ::getStyler
     * @covers ::__construct
     *
     * @return void
     */
    public function testApply(): void
    {
        $styler = $this->createMock(StylerInterface::class);
        $subject = new ConfigurableStyle(
            $styler,
            $this->createMock(StyleEnum::class)
        );

        $styler->expects(static::exactly(2))
            ->method('style')
            ->with($this->isInstanceOf(StyleEnum::class));

        $subject->apply();
        $subject->reset();
    }
}
