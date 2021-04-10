<?php

declare(strict_types=1);

use Fahim\CommissionTask\Entity\Currency;
use Fahim\CommissionTask\Exception\CurrencyShortCodeNotFoundException;
use Fahim\CommissionTask\Service\CurrencyCollections;
use PHPUnit\Framework\TestCase;

/**
 * Currency collections
 */
class CurrencyCollectionsTest extends TestCase
{
    /**
     * @var CurrencyCollections
     */
    private $currencyCollections;

    /**
     * Create Currency Collections
     * Then call pass currency array to make collections
     *
     * @return void
     */
    public function setUp()
    {
        $this->currencyCollections = new CurrencyCollections();
        $this->currencyCollections->makeCollectionFromArray(
            [
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
            ]
        );
    }

    /**
     * Get converted amount by currency short code
     *
     * @return void
     */
    public function testConvertAmountByShortCode()
    {
        $from = 'EUR';
        $to = 'JPY';
        $amount = 100;
        $result = $this->currencyCollections->convertAmountByShortCode($from, $to, $amount);
        $this->assertEquals(
            12953,
            $result
        );
    }

    /**
     * Get currency object by currency short code
     *
     * @return void
     */
    public function testGetCurrencyByShortCode()
    {
        $code = 'JPY';
        $result = $this->currencyCollections->getCurrencyByShortCode($code);
        $this->assertEquals(
            new Currency('JPY', 129.53, 0),
            $result
        );
    }
   
    /**
     * Get currency exception for undefined currency short code
     *
     * @return void
     */
    public function testGetCurrencyByShortCodeException()
    {
        $this->expectException(CurrencyShortCodeNotFoundException::class);
        $code ='NOT';
        $this->currencyCollections->getCurrencyByShortCode($code);
    }
}
