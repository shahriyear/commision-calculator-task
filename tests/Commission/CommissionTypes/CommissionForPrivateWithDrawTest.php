<?php

declare(strict_types=1);

use Fahim\CommissionTask\Commission\CommissionTypes\CommissionForPrivateWithDraw;
use Fahim\CommissionTask\Service\CurrencyCollections;
use Fahim\CommissionTask\Service\Func;
use Fahim\CommissionTask\Service\TransactionCollections;
use PHPUnit\Framework\TestCase;

/**
 * Commission for private withdraw
 */
class CommissionForPrivateWithDrawTest extends TestCase
{
    /**
     * @var CommissionForPrivateWithDraw
     */
    private $type;

    public function setUp()
    {
        $currencies = [
            [
                'currencyShortCode'    => 'EUR',
                'exchangeRate'      => 1,
                'precision' => 2,
            ],
            [
                'currencyShortCode'    => 'USD',
                'exchangeRate'      => 1.1497,
                'precision' => 2,
            ],
            [
                'currencyShortCode'    => 'JPY',
                'exchangeRate'      => 129.53,
                'precision' => 0,
            ]
        ];

        $transactions = [
            0 => [
              'date' => '2014-12-31',
              'userId' => '4',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '1200.00',
              'currencyShortCode' => 'EUR',
            ],
            1 => [
              'date' => '2015-01-01',
              'userId' => '4',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '1000.00',
              'currencyShortCode' => 'EUR',
            ],
            2 => [
              'date' => '2016-01-05',
              'userId' => '4',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '1000.00',
              'currencyShortCode' => 'EUR',
            ],
            3 => [
              'date' => '2016-01-05',
              'userId' => '1',
              'userType' => 'private',
              'operationType' => 'deposit',
              'amount' => '200.00',
              'currencyShortCode' => 'EUR',
            ],
            4 => [
              'date' => '2016-01-06',
              'userId' => '2',
              'userType' => 'business',
              'operationType' => 'withdraw',
              'amount' => '300.00',
              'currencyShortCode' => 'EUR',
            ],
            5 => [
              'date' => '2016-01-06',
              'userId' => '1',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '30000',
              'currencyShortCode' => 'JPY',
            ],
            6 => [
              'date' => '2016-01-07',
              'userId' => '1',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '1000.00',
              'currencyShortCode' => 'EUR',
            ],
            7 => [
              'date' => '2016-01-07',
              'userId' => '1',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '100.00',
              'currencyShortCode' => 'USD',
            ],
            8 => [
              'date' => '2016-01-10',
              'userId' => '1',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '100.00',
              'currencyShortCode' => 'EUR',
            ],
            9 => [
              'date' => '2016-01-10',
              'userId' => '2',
              'userType' => 'business',
              'operationType' => 'deposit',
              'amount' => '10000.00',
              'currencyShortCode' => 'EUR',
            ],
            10 => [
              'date' => '2016-01-10',
              'userId' => '3',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '1000.00',
              'currencyShortCode' => 'EUR',
            ],
            11 => [
              'date' => '2016-02-15',
              'userId' => '1',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '300.00',
              'currencyShortCode' => 'EUR',
            ],
            12 => [
              'date' => '2016-02-19',
              'userId' => '5',
              'userType' => 'private',
              'operationType' => 'withdraw',
              'amount' => '3000000',
              'currencyShortCode' => 'JPY',
            ],
        ];
        
        $currencyCollections = new CurrencyCollections($currencies);

        $transactionCollections = new TransactionCollections($transactions);

        $singleTransaction = $transactionCollections->getTransactions()[6];
        $this->type = new CommissionForPrivateWithDraw($singleTransaction, $currencyCollections, $transactionCollections);
    }

    /**
     * Generate Commission
     *
     * @return void
     */
    public function testCalculate()
    {
        $expecting = 0.70;
        $calculated = $this->type->calculate();
        $result = Func::roundWithPrecision($calculated, 2);
        $this->assertEquals(
            $expecting,
            $result
        );
    }
}
