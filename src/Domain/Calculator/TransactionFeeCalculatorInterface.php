<?php

namespace Ifx\Domain\Calculator;

interface TransactionFeeCalculatorInterface
{
    public function calculateFee(float $amount): float;
}
