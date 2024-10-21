<?php

namespace Ifx\Domain\Calculator;

final readonly class PercentageFeeCalculator implements TransactionFeeCalculatorInterface
{
    public function __construct(private float $feePercent = 0.005)
    {
    }

    public function calculateFee(float $amount): float
    {
        return round((float) bcmul((string) $amount, (string) $this->feePercent, 3), 2);
    }
}
