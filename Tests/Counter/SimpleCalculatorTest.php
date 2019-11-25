<?php

declare(strict_types=1);

namespace Ardiakov\FirstBundle\Tests\Counter;

use Ardiakov\FirstBundle\Services\Counter\Exceptions\NotExpectedSymbolException;
use Ardiakov\FirstBundle\Services\Counter\Exceptions\NullValueException;
use Ardiakov\FirstBundle\Services\Counter\SimpleCalculator;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class SimpleCalculatorTest extends TestCase
{
    public $service;

    protected function setUp(): void
    {
        $this->service = new SimpleCalculator();
    }

    /**
     * @dataProvider transformToReversePolishNotationDataProvider
     */
    public function testTransformToReversePolishNotation(?string $string, $expectedValue)
    {
        $this->assertEquals(
            $expectedValue,
            $this->invokeMethod($this->service, 'transformToReversePolishNotation', [$string]));
    }

    public function transformToReversePolishNotationDataProvider(): array
    {
        return [
            ['data' => '1 + 2 * 4', 'expected' => '1 2 4 * +'],
            ['data' => '6 * 2 - 2 / 3', 'expected' => '6 2 * 2 3 / -'],
        ];
    }

    public function testTransformToReversePolishNotationNotExpectedSymbolException()
    {
        $this->expectExceptionObject(new NotExpectedSymbolException('Symbol "4c" not expected'));
        $this->invokeMethod($this->service, 'transformToReversePolishNotation', ['1 + 2 * 4c']);
    }

    /**
     * @dataProvider calculateDataProvider
     */
    public function testCalculate(?string $string, $expectedValue)
    {
        $this->assertEquals(
            $expectedValue,
            round($this->invokeMethod($this->service, 'calculate', [$string]), 2));
    }

    public function calculateDataProvider(): array
    {
        return [
            ['data' => '1 2 4 * +', 'expected' => 9],
            ['data' => '6 2 * 2 3 / -', 'expected' => 11.33],
        ];
    }

    /**
     * @dataProvider countDataProvider
     */
    public function testCount(?string $string, $expectedValue)
    {
        $this->assertEquals(
            $expectedValue,
            round($this->service->count($string), 2)
        );
    }

    public function countDataProvider(): array
    {
        return [
            ['data' => '1 + 2 * 4', 'expected' => 9],
            ['data' => '6 * 2 - 2 / 3', 'expected' => 11.33],
        ];
    }

    public function testCountNullValueException()
    {
        $this->expectExceptionObject(new NullValueException());
        $this->service->count(null);
    }

    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(\get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}
