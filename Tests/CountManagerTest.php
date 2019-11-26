<?php

declare(strict_types=1);

namespace Ardiakov\StringStackCalcBundle\Tests;

use Ardiakov\StringStackCalcBundle\Services\Counter\SimpleCalculator;
use Ardiakov\StringStackCalcBundle\Services\CountManager;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class CountManagerTest extends TestCase
{
    public $service;

    protected function setUp(): void
    {
        $this->service = new CountManager(new SimpleCalculator());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCount(string $data, $expectedResult)
    {
        $this->assertEquals($expectedResult, round($this->service->count($data), 2));
    }

    public function dataProvider(): array
    {
        return [
            ['data' => '1 + 2 * 4', 'expectedResult' => 9],
            ['data' => '6 * 2 - 2 / 3', 'expectedResult' => 11.33],
        ];
    }
}
