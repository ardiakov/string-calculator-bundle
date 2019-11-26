<?php

declare(strict_types=1);

namespace Ardiakov\StringStackCalcBundle\Services\Counter\Exceptions;

class NotExpectedSymbolException extends SimpleCalculatorException
{
    protected $message = 'Symbol not expected';
}
