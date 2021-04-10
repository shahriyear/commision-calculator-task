<?php

declare(strict_types=1);

use Fahim\CommissionTask\Entity\Transaction;
use PHPUnit\Framework\TestCase;

/**
 * Transaction entity
 */
class TransactionTest extends TestCase
{
    
    /**
     * @var Transaction
     */
    private $transaction;

    public function setUp()
    {
        $transaction= [
            99,
            new \DateTime('2014-12-31'),
            4,
            'private',
            'withdraw',
            1200.00,
            'EUR'
        ];
        $this->transaction = new Transaction(...$transaction);
    }

    /**
     * Transaction id
     *
     * @return void
     */
    public function testGetTransactionId()
    {
        $result = $this->transaction->getTransactionId();
        $this->assertEquals(
            99,
            $result
        );
    }

    /**
     * Transaction date
     *
     * @return void
     */
    public function testGetDate()
    {
        $result = $this->transaction->getDate();
        $this->assertEquals(
            new \DateTime('2014-12-31'),
            $result
        );
    }

    /**
     * Transaction user id
     *
     * @return void
     */
    public function testGetUserId()
    {
        $result = $this->transaction->getUserId();
        $this->assertEquals(
            4,
            $result
        );
    }

    /**
     * Transaction amount
     *
     * @return void
     */
    public function testGetAmount()
    {
        $result = $this->transaction->getAmount();
        $this->assertEquals(
            1200.00,
            $result
        );
    }

    /**
     * Transaction currency short code
     *
     * @return void
     */
    public function testGetCurrencyShortCode()
    {
        $result = $this->transaction->getCurrencyShortCode();
        $this->assertEquals(
            'EUR',
            $result
        );
    }
}
