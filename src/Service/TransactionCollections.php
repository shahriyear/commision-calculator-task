<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Service;

use Fahim\CommissionTask\Entity\Transaction;

/**
 * This is a class for making transaction entity
 */
class TransactionCollections
{
    /**
     *@var array
     */
    private $transactions = [];

    /**
     * can initialize with transaction
     *
     * @param array $transactions
     */
    public function __construct(array $transactions = [])
    {
        if (!empty($transactions)) {
            $this->makeCollectionFromArray($transactions);
        }
    }


    /**
     * convert array to transaction
     *
     * @param array $transactions
     * @return self
     */
    public function makeCollectionFromArray(array $transactions):self
    {
        foreach ($transactions as $key => $transaction) {
            $prepareTransaction = [
                ++$key,
                new \DateTime($transaction['date']),
                intval($transaction['userId']),
                strtolower($transaction['userType']),
                strtolower($transaction['operationType']),
                $transaction['amount'],
                strtoupper($transaction['currencyShortCode'])
            ];
            $this->transactions[] = new Transaction(...$prepareTransaction);
        }
        return $this;
    }


    /**
     * get all transactions
     *
     * @return array
     */
    public function getTransactions():array
    {
        return $this->transactions;
    }
}
