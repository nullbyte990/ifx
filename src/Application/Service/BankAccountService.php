<?php

namespace Ifx\Application\Service;

use Ifx\Application\Exception\DebitOperationsLimitExceededException;
use Ifx\Application\Exception\InsufficientBalanceException;
use Ifx\Application\Exception\InvalidCurrencyException;
use Ifx\Domain\Calculator\PercentageFeeCalculator;
use Ifx\Domain\Model\BankAccount;
use Ifx\Domain\Model\Payment;

final class BankAccountService
{
    /**
     * @throws InvalidCurrencyException
     */
    public function handleCredit(BankAccount $account, Payment $payment): void
    {
        $account->credit($payment);
    }

    /**
     * @throws DebitOperationsLimitExceededException
     * @throws InsufficientBalanceException
     * @throws InvalidCurrencyException
     */
    public function handleDebit(BankAccount $account, Payment $payment): void
    {
        $feeCalculator = new PercentageFeeCalculator();
        $account->debit($payment, $feeCalculator);
    }
}
