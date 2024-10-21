<?php

namespace Ifx\Application\Service;

use Ifx\Domain\Calculator\PercentageFeeCalculator;
use Ifx\Domain\Model\BankAccount;
use Ifx\Domain\Model\Payment;

final class BankAccountService
{
    public function handleCredit(BankAccount $account, Payment $payment): void
    {
        $account->credit($payment);
    }

    public function handleDebit(BankAccount $account, Payment $payment): void
    {
        $feeCalculator = new PercentageFeeCalculator();
        $account->debit($payment, $feeCalculator);
    }
}
