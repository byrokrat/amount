<?php

namespace byrokrat\amount\Rounder;

/**
 * Make a toolkit availiable
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
