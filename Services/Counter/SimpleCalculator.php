<?php

declare(strict_types=1);

namespace Ardiakov\StringStackCalcBundle\Services\Counter;

use Ardiakov\StringStackCalcBundle\Services\Counter\Exceptions\NotExpectedSymbolException;
use Ardiakov\StringStackCalcBundle\Services\Counter\Exceptions\NullValueException;
use Ardiakov\StringStackCalcBundle\Services\Counter\Exceptions\SimpleCalculatorException;

class SimpleCalculator implements CounterServiceInterface
{
    /**
     * @param null|string $string
     *
     * @throws NullValueException
     *
     * @return float|int|SimpleCalculatorException
     */
    public function count(?string $string)
    {
        if (null === $string) {
            throw new NullValueException();
        }

        try {
            $reversPolishNotation = $this->transformToReversePolishNotation($string);
        } catch (SimpleCalculatorException $exception) {
            return $exception;
        }

        try {
            return $this->calculate($reversPolishNotation);
        } catch (SimpleCalculatorException $exception) {
            return $exception;
        }
    }

    /**
     * @param string $string
     *
     * @throws NotExpectedSymbolException
     *
     * @return string
     */
    private function transformToReversePolishNotation(string $string): string
    {
        $stack = [];
        $out = [];

        $operatorsPriority = [
            '*' => 2,
            '/' => 2,
            '+' => 1,
            '-' => 1,
        ];

        foreach (explode(' ', $string) as $index => $element) {
            if (is_numeric($element)) {
                $out[] = $element;
            } else {
                if (!isset($operatorsPriority[$element])) {
                    throw new NotExpectedSymbolException(sprintf('Symbol "%s" not expected', $element));
                }

                if (false !== end($stack)) {
                    if ($operatorsPriority[end($stack)] >= $operatorsPriority[$element]) {
                        $out[] = array_pop($stack);
                    }
                }

                $stack[] = $element;
            }
        }

        return implode(' ', array_merge($out, array_reverse($stack)));
    }

    /**
     * @param null|string $string
     *
     * @throws NotExpectedSymbolException
     *
     * @return float|int
     */
    private function calculate(?string $string)
    {
        $stack = [];

        $operatorsAndOperationsMap = [
            '*' => static function ($a, $b) {
                return $a * $b;
            },
            '/' => static function ($a, $b) {
                return $a / $b;
            },
            '+' => static function ($a, $b) {
                return $a + $b;
            },
            '-' => static function ($a, $b) {
                return $a - $b;
            },
        ];

        $token = strtok($string, ' ');

        while (false !== $token) {
            if (\array_key_exists($token, $operatorsAndOperationsMap)) {
                $elementB = array_pop($stack);
                $elementA = array_pop($stack);

                $stack[] = $operatorsAndOperationsMap[$token]($elementA, $elementB);
            } elseif (is_numeric($token)) {
                $stack[] = $token;
            } else {
                throw new NotExpectedSymbolException(sprintf('Symbol "%s" not expected', $token));
            }
            $token = strtok(' ');
        }

        return array_pop($stack);
    }
}
