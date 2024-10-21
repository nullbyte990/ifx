<?php

namespace Ifx\Domain\Model;

use Ifx\Application\Exception\DailyPaymentsExceededException;
use Ifx\Application\Exception\InsufficientBalanceException;
use Ifx\Application\Exception\InvalidCurrencyException;
use Ifx\Domain\Calculator\TransactionFeeCalculatorInterface;
use Ifx\Domain\CurrencyEnum;

final class BankAccount
{
    private float $balance;
    private int $dailyPaymentCount = 0;
    private const MAX_DAILY_PAYMENTS = 3;

    public function __construct(
        private readonly CurrencyEnum $currency
    ) {
    }

    public function credit(Payment $payment): void
    {
        if ($payment->currency !== $this->currency) {
            throw new InvalidCurrencyException("Currency mismatch.");
        }

        $this->balance += $payment->amount;
    }

    public function debit(Payment $payment, TransactionFeeCalculatorInterface $feeCalculator): void
    {
        if ($payment->currency !== $this->currency) {
            throw new InvalidCurrencyException("Currency mismatch.");
        }

        if ($this->dailyPaymentCount >= self::MAX_DAILY_PAYMENTS) {
            throw new DailyPaymentsExceededException("Maximum daily payments exceeded.");
        }

        $totalAmount = $payment->amount + $feeCalculator->calculateFee($payment->amount);

        if ($totalAmount > $this->balance) {
            throw new InsufficientBalanceException();
        }

        $this->balance -= $totalAmount;
        $this->dailyPaymentCount++;
    }
}
