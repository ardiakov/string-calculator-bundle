<?php

declare(strict_types=1);

namespace Ardiakov\FirstBundle\Tests;

use Ardiakov\FirstBundle\Services\Counter\SimpleCalculator;
use Ardiakov\FirstBundle\Services\CountManager;
use PHPUnit\Framework\TestCase;

class CountManagerTest extends TestCase
{
    public $service;

    /**
     * @dataProvider dataProvider
     */
    public function testCount(string $data, $expectedResult)
    {
        $this->assertEquals($expectedResult, round($this->service->count($data),2));
    }

    public function dataProvider(): array
    {
        return [
            ['data' => '1 + 2 * 4', 'expectedResult' => 9],
            ['data' => '6 * 2 - 2 / 3', 'expectedResult' => 11.33],
        ];
    }

    protected function setUp(): void
    {
        $this->service = new CountManager(new SimpleCalculator());
    }
}
