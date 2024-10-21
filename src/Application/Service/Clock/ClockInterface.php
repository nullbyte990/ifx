<?php

namespace Ifx\Application\Service\Clock;

interface ClockInterface
{
    public function now(): \DateTimeImmutable;
}
