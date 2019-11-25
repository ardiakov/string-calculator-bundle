<?php

declare(strict_types=1);

namespace Ardiakov\FirstBundle\Services\Counter\Exceptions;

class NotExpectedSymbolException extends SimpleCalculatorException
{
    protected $message = 'Symbol not expected';
}
