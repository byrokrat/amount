<?php

declare(strict_types = 1);

namespace byrokrat\amount;

/**
 * Exception thrown on division by zero
 */
class DivisionByZeroException extends \RuntimeException implements Exception
{
}
