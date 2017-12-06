<?php

declare(strict_types = 1);

namespace byrokrat\amount;

/**
 * Exception thrown if an argument is not of the expected type or form
 */
class InvalidArgumentException extends \InvalidArgumentException implements Exception
{
}
