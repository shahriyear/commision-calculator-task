<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Commission\CommissionTypes;

use Fahim\CommissionTask\Entity\Transaction;
use Fahim\CommissionTask\Service\CurrencyCollections;
use Fahim\CommissionTask\Service\TransactionCollections;

/**
 * Commission type base class
 */
class CommissionTypeBase
{
    /**
     * @var Transaction
     */
    protected $transaction;

    /**
     * @var CurrencyCollections
     */
    protected $currencyCollections;

    /**
     * @var TransactionCollections
     */
    protected $transactionCollections;

    /**
     *
     * @param Transaction $transaction
     * @param CurrencyCollections $currencyCollections
     * @param TransactionCollections $transactionCollections
     */
    public function __construct(
        Transaction $transaction,
        CurrencyCollections $currencyCollections,
        TransactionCollections $transactionCollections
    ) {
        $this->transaction = $transaction;
        $this->currencyCollections = $currencyCollections;
        $this->transactionCollections = $transactionCollections;
    }
}
