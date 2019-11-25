<?php

declare(strict_types=1);

namespace Ardiakov\FirstBundle\Services\Counter;

interface CounterServiceInterface
{
    public function count(?string $string);
}
