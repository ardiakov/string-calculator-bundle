<?php

declare(strict_types=1);

namespace Ardiakov\StringStackCalcBundle\Services\Counter\Exceptions;

class NullValueException extends SimpleCalculatorException
{
    protected $message = 'Null value pass in Counter Service';
}
