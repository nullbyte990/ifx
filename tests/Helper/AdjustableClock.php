<?php

namespace Tests\Helper;

use Ifx\Application\Service\Clock\ClockInterface;

class AdjustableClock implements ClockInterface
{
    private \DateTimeImmutable $currentTime;

    public function __construct(\DateTimeImmutable $initialTime)
    {
        $this->currentTime = $initialTime;
    }

    public function now(): \DateTimeImmutable
    {
        return $this->currentTime;
    }

    public function setTime(\DateTimeImmutable $time): void
    {
        $this->currentTime = $time;
    }
}
