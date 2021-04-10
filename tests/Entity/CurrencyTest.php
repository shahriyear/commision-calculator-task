<?php

declare(strict_types=1);

use Fahim\CommissionTask\Entity\Currency;
use PHPUnit\Framework\TestCase;

/**
 * Currency entity
 */
class CurrencyTest extends TestCase
{
    /**
     * @var Currency
     */
    private $currency;

    /**
     * Create Currency by passing data
     *
     * @return void
     */
    public function setUp()
    {
        $this->currency = new Currency('JPY', 129.53, 5);
    }

    /**
     * currency short code
     *
     * @return void
     */
    public function testGetCurrencyShortCode()
    {
        $result = $this->currency->getCurrencyShortCode();
        $this->assertEquals(
            'JPY',
            $result
        );
    }

    /**
     * currency exchange rate
     *
     * @return void
     */
    public function testGetExchangeRate()
    {
        $result = $this->currency->getExchangeRate();
        $this->assertEquals(
            129.53,
            $result
        );
    }


    /**
     * currency precision
     *
     * @return void
     */
    public function testGetPrecision()
    {
        $result = $this->currency->getPrecision();
        $this->assertEquals(
            5,
            $result
        );
    }
}
