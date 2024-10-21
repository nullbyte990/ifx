<?php

namespace Ifx\Domain;

enum CurrencyEnum: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case PLN = 'PLN';
    case GBP = 'GBP';
    case AUD = 'AUD';
}
