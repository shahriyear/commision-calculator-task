<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Commission;

use Fahim\CommissionTask\Service\Func;

/**
 * Commission facade
 */
class Commission extends CommissionAbstract
{
    public function calculateCommission()
    {
        $instance = $this->getInstanceByUserAndOperationType();
        $fee = $instance->calculate();
        
        $currencyShortCode = $this->transaction->getCurrencyShortCode();
        $currency = $this->currencyCollections->getCurrencyByShortCode($currencyShortCode);
        
        return Func::roundWithPrecision($fee, $currency->getPrecision());
    }
}
