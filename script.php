<?php

require_once __DIR__ . '/vendor/autoload.php';
 
use Fahim\CommissionTask\CalculateCommissions;
use Fahim\CommissionTask\Service\CurrencyCollections;
use Fahim\CommissionTask\Service\CsvReader;
use Fahim\CommissionTask\Service\TransactionCollections;

/**
 * Step 1
 * Create currency collection from given currencies
 */
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

$currencyCollections = new CurrencyCollections($currencies);

/**
 * Step 2
 * Read CSV to create a associative array
 */
$columns = ['date','userId','userType','operationType','amount','currencyShortCode'];
$csv = new CsvReader('./input.csv', $columns);

/**
 * Step 3
 * Create transaction collection form array provided by csv
 */
$transactionCollections = new TransactionCollections($csv->toArray());

/**
 * Step 4
 * Calculate commissions with transaction collection and currency collection
 */
$calculate = new CalculateCommissions($transactionCollections, $currencyCollections);
$calculate->generateCommission();
$calculate->getFeesInHorizontally();
