<?php

namespace Tests\Unit;

use Ifx\Application\Exception\InvalidAmountException;
use Ifx\Domain\CurrencyEnum;
use Ifx\Domain\Model\Payment;
use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase
{
    public function testIfAmountCannotBeLowerThanZero(): void
    {
        $amount = -1;

        $this->expectException(InvalidAmountException::class);

        new Payment($amount, CurrencyEnum::EUR);
    }
}
