<?php

namespace Ifx\Application\Handler;

use Ifx\Domain\Calculator\PercentageFeeCalculator;
use Ifx\Domain\Model\BankAccount;
use Ifx\Domain\Model\Payment;

final class HandlePayOut
{
    public function __invoke(BankAccount $bankAccount, Payment $payment)
    {
        $bankAccount->debit($payment, new PercentageFeeCalculator());
    }
}
