<?php

namespace Ifx\Domain\Model;

use Ifx\Application\Exception\InvalidAmountException;
use Ifx\Domain\CurrencyEnum;

final readonly class Payment
{
    public function __construct(
        public float $amount,
        public CurrencyEnum $currency
    ) {
        if ($this->amount <= 0) {
            throw new InvalidAmountException(message: 'The amount cannot be less than or equal to zero');
        }
    }
}
