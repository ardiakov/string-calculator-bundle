<?php

declare(strict_types=1);

namespace Ardiakov\StringStackCalcBundle\Services\Counter;

interface CounterServiceInterface
{
    public function count(?string $string);
}
