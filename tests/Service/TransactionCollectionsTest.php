<?php

declare(strict_types=1);

use Fahim\CommissionTask\Entity\Transaction;
use Fahim\CommissionTask\Service\TransactionCollections;
use PHPUnit\Framework\TestCase;

/**
 * Transaction Collections
 */
class TransactionCollectionsTest extends TestCase
{
    /**
     * @var TransactionCollections
     */
    private $transactionsCollections;

    /**
     * Create transaction collections
     *
     * @return void
     */
    public function setUp()
    {
        $this->transactionsCollections =  new TransactionCollections();
    }


    /**
     * Get transactions
     *
     * @return void
     */
    public function testGetTransactions()
    {
        $transactions =
        [
            [
                'date' => '2014-12-31',
                'userId' => 4,
                'userType' => 'private',
                'operationType' => 'withdraw',
                'amount' => 1200.00,
                'currencyShortCode' =>'EUR'
            ]
        ];

        $transaction = $transactions[0];
        
        $expecting = new Transaction(...[
            1,
            new \DateTime($transaction['date']),
            $transaction['userId'],
            $transaction['userType'],
            $transaction['operationType'],
            $transaction['amount'],
            $transaction['currencyShortCode']
        ]);

        $result = $this->transactionsCollections
        ->makeCollectionFromArray($transactions)
        ->getTransactions();

        $this->assertEquals(
            $expecting,
            $result[0]
        );
    }


    /**
     * Get transactions empty
     *
     * @return void
     */
    public function testGetTransactionsEmpty()
    {
        $result = $this->transactionsCollections
        ->makeCollectionFromArray([])
        ->getTransactions();

        $this->assertEquals(
            [],
            $result
        );
    }
}
