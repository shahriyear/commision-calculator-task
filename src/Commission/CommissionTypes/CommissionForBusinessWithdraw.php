<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Commission\CommissionTypes;

use Fahim\CommissionTask\Commission\CommissionInterface;
use Fahim\CommissionTask\Service\Func;

/**
 * Commission calculate for business withdraw
 */
class CommissionForBusinessWithdraw extends CommissionTypeBase implements CommissionInterface
{
    private const COMMISSION_RATE = 0.5;

    public function calculate()
    {
        return Func::getPercentage($this->transaction->getAmount(), self::COMMISSION_RATE);
    }
}
