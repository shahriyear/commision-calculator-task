<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Entity;

/**
 *Get currency array and convert it to objects
 */
class Currency
{
    /**
     * Currency Short Code
     * @var string
     */
    protected $currencyShortCode;

    /**
     * Exchange Rate of currency
     * @var int|float
     */
    protected $exchangeRate;

    /**
     * Precision for exchange rate
     * @var int
     */
    protected $precision;

    /**
     * @param string $currencyShortCode
     * @param int|float $exchangeRate
     * @param integer $precision
     */
    public function __construct(string $currencyShortCode, $exchangeRate, int $precision)
    {
        $this->currencyShortCode = $currencyShortCode;
        $this->exchangeRate = $exchangeRate;
        $this->precision = $precision;
    }

    /**
     * @return string
     */
    public function getCurrencyShortCode():string
    {
        return $this->currencyShortCode;
    }

    /**
     * @return int|float
     */
    public function getExchangeRate()
    {
        return $this->exchangeRate;
    }

    /**
     * @return int
     */
    public function getPrecision():int
    {
        return $this->precision;
    }
}
