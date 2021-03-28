<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace GrizzIt\Cli\Common\Io;

interface PointerInterface
{
    /**
     * Moves the pointer up x line(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerUp(int $steps): void;

    /**
     * Moves the pointer down x line(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerDown(int $steps): void;

    /**
     * Moves the pointer left x column(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerLeft(int $steps): void;

    /**
     * Moves the pointer right x column(s).
     *
     * @param int $steps
     *
     * @return void
     */
    public function pointerRight(int $steps): void;
}
