<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Commission\CommissionTypes;

use Fahim\CommissionTask\Commission\CommissionInterface;
use Fahim\CommissionTask\Service\Func;

/**
 * Commission calculate for private withdraw
 */
class CommissionForPrivateWithDraw extends CommissionTypeBase implements CommissionInterface
{
    /**
     * Commission Rate
     */
    private const COMMISSION_RATE = 0.3;

    /**
     * Rules for charging
     */
    private const CHARGE_RULES = [
        'currencyShortCode'      => 'EUR',
        'maximumAmount'        => 1000,
        'maximumOperation' => 3
    ];

    /**
     * Calculate
     *
     * @return int|float
     */
    public function calculate()
    {
        return Func::getPercentage(
            $this->getChargeableAmount(),
            self::COMMISSION_RATE
        );
    }

    /**
     * Check for what type of rule meets
     *
     * @return void
     */
    private function getChargeableAmount()
    {
        $filteredTransactions = $this->getPreviousWeekFilteredTransactions();

        if (empty($filteredTransactions)) {
            return $this->getChargeableAmountForNoPreviousOpreationTransaction();
        }

        return $this->getChargeableAmountByMaximumLimitAndAmount($filteredTransactions);
    }


    /**
     * Check for same week transactions
     *
     * @return void
     */
    private function getPreviousWeekFilteredTransactions()
    {
        return array_filter(
            $this->transactionCollections->getTransactions(),
            function ($transaction) {
                return $transaction->getTransactionId() < $this->transaction->getTransactionId()
                    && $transaction->getDate()->format('oW') === $this->transaction->getDate()->format('oW')
                    && $transaction->getOperationType() === $this->transaction->getOperationType()
                    && $transaction->getUserId() === $this->transaction->getUserId();
            }
        );
    }

    /**
     * If no previous transaction get charging amount
     *
     * @return void
     */
    private function getChargeableAmountForNoPreviousOpreationTransaction()
    {
        $maximumAmount = $this->currencyCollections->convertAmountByShortCode(
            self::CHARGE_RULES['currencyShortCode'],
            $this->transaction->getCurrencyShortCode(),
            self::CHARGE_RULES['maximumAmount']
        );
        
        $amount = $this->transaction->getAmount();
        
        if ($amount < $maximumAmount) {
            return 0;
        }

        return $amount - $maximumAmount;
    }


    /**
     * Get chargeable amount by filtering with maximum amount and maximum limit
     *
     * @param array $filteredTransactions
     * @return void
     */
    private function getChargeableAmountByMaximumLimitAndAmount($filteredTransactions)
    {
        list($totalOperation, $totalAmount) = $this->getTotalOfPreviousOperationAndAmount(
            $filteredTransactions
        );
        
        $amount = $this->transaction->getAmount();
        $code = $this->transaction->getCurrencyShortCode();
        $exchangeRate = $this->currencyCollections->getCurrencyByShortCode($code)->getExchangeRate();
        
        $limitLeft = $totalAmount - self::CHARGE_RULES['maximumAmount'];
        $limitLeftOwnCurrency = $limitLeft / $exchangeRate;

        if (0 >= $limitLeft && self::CHARGE_RULES['maximumOperation'] >= $totalOperation) {
            return $amount-abs($limitLeftOwnCurrency);
        }
        
        return $amount;
    }

    /**
     * Get total operations and total operation amounts
     *
     * @param array $filteredTransactions
     * @return void
     */
    private function getTotalOfPreviousOperationAndAmount($filteredTransactions)
    {
        $totalOperation = 0;
        $totalAmount = 0;
        foreach ($filteredTransactions as $filteredTransaction) {
            $tempAmount = $this->currencyCollections->convertAmountByShortCode(
                $filteredTransaction->getCurrencyShortCode(),
                self::CHARGE_RULES['currencyShortCode'],
                $filteredTransaction->getAmount()
            );
            
            $totalAmount += $tempAmount;
            $totalOperation++;
        }
        return [$totalOperation,$totalAmount];
    }
}
