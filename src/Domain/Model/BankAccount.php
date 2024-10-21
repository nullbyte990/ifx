<?php

namespace Ifx\Domain\Model;

use Ifx\Application\Exception\InsufficientBalanceException;
use Ifx\Application\Exception\InvalidAmountException;
use Ifx\Application\Exception\InvalidCurrencyException;
use Ifx\Application\Exception\DebitOperationsLimitExceededException;
use Ifx\Domain\Calculator\TransactionFeeCalculatorInterface;
use Ifx\Domain\CurrencyEnum;

final class BankAccount
{
    private float $balance;
    private int $dailyDebitOperationsCount = 0;

    /**
     * @throws InvalidAmountException
     */
    public function __construct(
        public readonly CurrencyEnum $currency,
        float $initialBalance = 0,
        private readonly int $dailyDebitOperationsLimit = 3
    ) {
        if ($initialBalance < 0) {
            throw new InvalidAmountException(message: 'The initial balance cannot be less than or equal to zero');
        }
        $this->balance = $initialBalance;
    }

    /**
     * @throws InvalidCurrencyException
     */
    public function credit(Payment $payment): void
    {
        if ($payment->currency !== $this->currency) {
            throw new InvalidCurrencyException('Currency mismatch.');
        }

        $this->balance += $payment->amount;
    }

    /**
     * @throws DebitOperationsLimitExceededException
     * @throws InsufficientBalanceException
     * @throws InvalidCurrencyException
     */
    public function debit(Payment $payment, TransactionFeeCalculatorInterface $feeCalculator): void
    {
        if ($payment->currency !== $this->currency) {
            throw new InvalidCurrencyException('Currency mismatch.');
        }

        if ($this->dailyDebitOperationsCount >= $this->dailyDebitOperationsLimit) {
            throw new DebitOperationsLimitExceededException('Daily debit operations limit exceeded.');
        }

        $totalAmount = $payment->amount + $feeCalculator->calculateFee($payment->amount);

        if ($totalAmount > $this->balance) {
            throw new InsufficientBalanceException();
        }

        $this->balance -= $totalAmount;
        ++$this->dailyDebitOperationsCount;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function resetDebitOperationsCount(): void
    {
        $this->dailyDebitOperationsCount = 0;
    }
}
