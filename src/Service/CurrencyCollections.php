<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Service;

use Fahim\CommissionTask\Entity\Currency;
use Fahim\CommissionTask\Exception\CurrencyShortCodeNotFoundException;

/**
 * Make collection entity from currency array
 */
class CurrencyCollections
{
    /**
     *@var array
     */
    private $currencies = [];

    /**
     * Currency array
     *
     * @param array $currencies
     */
    public function __construct(array $currencies = [])
    {
        if (!empty($currencies)) {
            $this->makeCollectionFromArray($currencies);
        }
    }

    /**
     * Get array and create new currency and assign
     *
     * @param array $currencies
     * @return self
     */
    public function makeCollectionFromArray(array $currencies):self
    {
        foreach ($currencies as $currency) {
            $this->currencies[$currency['currencyShortCode']] = new Currency(...array_values($currency));
        }
        return $this;
    }

    /**
     * Find the currency object form currencies array
     *
     * @param string $currencyShortCode
     * @return Currency
     */
    public function getCurrencyByShortCode(string $currencyShortCode):Currency
    {
        if (!isset($currencyShortCode) || ! array_key_exists($currencyShortCode, $this->currencies)) {
            throw new CurrencyShortCodeNotFoundException("{$currencyShortCode} is not found in currencies");
        }
        return $this->currencies[$currencyShortCode];
    }


    /**
     * Convert amount using currency short to another currency
     *
     * @param string $currencyShortCode
     * @param int|float $amount
     * @return int|float
     */
    public function convertAmountByShortCode(
        string $fromCurrencyShortCode,
        string $toCurrencyShortCode,
        $amount
    ) {
        $fromCurrency =  $this->getCurrencyByShortCode($fromCurrencyShortCode);
        $toCurrency =   $this->getCurrencyByShortCode($toCurrencyShortCode);

        if ($fromCurrency->getExchangeRate() > $toCurrency->getExchangeRate()) {
            return $amount / $fromCurrency->getExchangeRate();
        }
        return $amount * $toCurrency->getExchangeRate();
    }
}
