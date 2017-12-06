<?php

declare(strict_types = 1);

namespace byrokrat\amount\Rounder;

/**
 * Make a rounding toolkit availiable
 */
trait ToolkitConsumer
{
    /**
     * @var Toolkit
     */
    protected $toolkit;

    public function __construct(Toolkit $toolkit = null)
    {
        $this->toolkit = $toolkit ?: new Toolkit;
    }
}
