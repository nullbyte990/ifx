<?php

namespace Ifx\Domain\Calculator;

readonly class PercentageFeeCalculator implements TransactionFeeCalculatorInterface
{
    public function __construct(private float $feePercent = 0.005)
    {
    }

    public function calculateFee(float $amount): float
    {
        return $amount * $this->feePercent;
    }
}
