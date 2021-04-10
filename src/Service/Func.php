<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Service;

use Fahim\CommissionTask\Exception\NotNumericException;

/**
 * Helper functions
 */
class Func
{
    /**
     * Calculate percentage of amount
     *
     * @param int|float $amount
     * @param int|float $percentage
     * @return int|float
     */
    public static function getPercentage($amount, $percentage)
    {
        if (!is_numeric($amount)) {
            throw new NotNumericException('Amount must be integer or float');
        }
        if ($amount>0) {
            return ($amount * $percentage) / 100;
        }
        return 0;
    }

    /**
     * Round and format
     *
     * @param int|float $amount
     * @param int $precision
     * @return void
     */
    public static function roundWithPrecision($amount, int $precision)
    {
        $multiplier = pow(10, $precision);
        $newAmount  = ceil($amount* $multiplier)/$multiplier;
                
        return number_format($newAmount, $precision, '.', '');
    }
}
