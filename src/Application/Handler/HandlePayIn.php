<?php

namespace Ifx\Application\Handler;

use Ifx\Domain\Model\BankAccount;
use Ifx\Domain\Model\Payment;

final class HandlePayIn
{
    public function __invoke(BankAccount $bankAccount, Payment $payment)
    {
        $bankAccount->credit($payment);
    }
}
