<?php

declare(strict_types=1);

namespace Ardiakov\StringStackCalcBundle\Services;

use Ardiakov\StringStackCalcBundle\Services\Counter\CounterServiceInterface;

final class CountManager
{
    /**
     * @var CounterServiceInterface
     */
    private $counterService;

    public function __construct(CounterServiceInterface $counterService)
    {
        $this->counterService = $counterService;
    }

    public function count(?string $string)
    {
        return $this->counterService->count($string);
    }
}
