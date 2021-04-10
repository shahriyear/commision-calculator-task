<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Commission;

/**
 * Interface for different types of commission
 */
interface CommissionInterface
{
    /**
     * @return int|float
     */
    public function calculate();
}
