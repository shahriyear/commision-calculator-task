<?php

declare(strict_types=1);

namespace Fahim\CommissionTask;

use Fahim\CommissionTask\Commission\Commission;
use Fahim\CommissionTask\Service\CurrencyCollections;
use Fahim\CommissionTask\Service\TransactionCollections;

/**
 * Commission calculator
 */
class CalculateCommissions
{
    /**
     * Transaction collections
     *
     * @var TransactionCollections
     */
    private $transactionCollections;
 
    /**
     * Currency collections
     *
     * @var CurrencyCollections
     */
    private $currencyCollections;

    /**
     * Store commissions
     *
     * @var array
     */
    private $fees = [];

    /**
     * Initiated constructor with transaction collections and currency collections
     *
     * @param TransactionCollections $transactionCollections
     * @param CurrencyCollections $currencyCollections
     */
    public function __construct(
        TransactionCollections $transactionCollections,
        CurrencyCollections $currencyCollections
    ) {
        $this->transactionCollections = $transactionCollections;
        $this->currencyCollections = $currencyCollections;
    }

    /**
     * Commissions calculation based on transactions and currencies
     *
     * @return array
     */
    public function generateCommission()
    {
        $fees = [];
        foreach ($this->transactionCollections->getTransactions() as $transaction) {
            $commission = new Commission($transaction, $this->currencyCollections, $this->transactionCollections);
            $fees[] = $commission->calculateCommission();
        }
        $this->fees = $fees;
        return $fees;
    }

    /**
     * To display fees horizontal order
     *
     * @return void
     */
    public function getFeesInHorizontally()
    {
        if (!empty($this->fees)) {
            echo implode(PHP_EOL, $this->fees).PHP_EOL;
        }
    }
}
