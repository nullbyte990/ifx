<?php

namespace Integration;

use Ifx\Application\Exception\InsufficientBalanceException;
use Ifx\Application\Exception\InvalidCurrencyException;
use Ifx\Application\Exception\PaymentsLimitExceededException;
use Ifx\Application\Service\BankAccountService;
use Ifx\Domain\CurrencyEnum;
use Ifx\Domain\Model\BankAccount;
use Ifx\Domain\Model\Payment;
use PHPUnit\Framework\TestCase;

class BankAccountServiceTest extends TestCase
{
    private BankAccountService $bankAccountService;

    protected function setUp(): void
    {
        $this->bankAccountService = new BankAccountService();
    }

    public function testIfBalanceIsIncreasedOnCredit(): void
    {
        $bankAccount = new BankAccount(CurrencyEnum::EUR);
        $payment = new Payment(100, CurrencyEnum::EUR);

        $this->bankAccountService->handleCredit($bankAccount, $payment);

        $this->assertEquals($payment->amount, $bankAccount->getBalance());
    }

    public function testIfBalanceIsDecreasedOnDebit(): void
    {
        $bankAccount = new BankAccount(CurrencyEnum::EUR, initialBalance: 1000);
        $payment = new Payment(100, CurrencyEnum::EUR);

        $this->bankAccountService->handleDebit($bankAccount, $payment);

        $this->assertEquals(899.5, $bankAccount->getBalance());
    }

    public function testIfCurrencyMismatchThrowsException(): void
    {
        $bankAccount = new BankAccount(CurrencyEnum::EUR);
        $payment = new Payment(100, CurrencyEnum::GBP);

        $this->expectException(InvalidCurrencyException::class);

        $this->bankAccountService->handleCredit($bankAccount, $payment);
    }

    public function testIfDebitThrowsExceptionOnInsufficientFunds(): void
    {
        $bankAccount = new BankAccount(CurrencyEnum::EUR, initialBalance: 50);
        $payment = new Payment(100, CurrencyEnum::EUR);

        $this->expectException(InsufficientBalanceException::class);

        $this->bankAccountService->handleDebit($bankAccount, $payment);
    }

    public function testIfDebitThrowsExceptionOnDailyQuotaExceeded(): void
    {
        $bankAccount = new BankAccount(
            CurrencyEnum::EUR,
            initialBalance: 100,
            debitDailyQuota: 1
        );
        $payment = new Payment(10, CurrencyEnum::EUR);

        $this->bankAccountService->handleDebit($bankAccount, $payment);
        $this->expectException(PaymentsLimitExceededException::class);
        $this->bankAccountService->handleDebit($bankAccount, $payment);
    }
}
