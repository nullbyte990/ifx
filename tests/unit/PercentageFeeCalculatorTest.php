<?php

namespace unit;

use Ifx\Domain\Calculator\PercentageFeeCalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PercentageFeeCalculatorTest extends TestCase
{
    #[DataProvider('dataProvider')]
    public function testIfFeeIsProperlyCalculated(float $amount, float $percent, float $expectedFee): void
    {
        $calculator = new PercentageFeeCalculator($percent);

        $fee = $calculator->calculateFee($amount);

        $this->assertEquals($fee, $expectedFee);
    }

    public static function dataProvider(): iterable
    {
        yield [100, 0.29, 29];

        yield [100, 0.005, 0.5];

        yield [1, 0.005, 0.01];

        yield [1, 0.004, 0.];
    }
}
