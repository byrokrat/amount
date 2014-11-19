<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 */

namespace ledgr\amount\Rounder;

/**
 * Make a toolkit availiable
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait ToolkitConsumer
{
    /**
     * @var Toolkit Rounding toolkit
     */
    protected $toolkit;

    /**
     * Inject rounding toolkit
     *
     * @param Toolkit $toolkit
     */
    public function __construct(Toolkit $toolkit = null)
    {
        $this->toolkit = $toolkit ?: new Toolkit;
    }
}
