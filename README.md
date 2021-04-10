### Run the script file

```php
➜  php script.php

0.60
3.00
0.00
0.06
1.50
0
0.70
0.30
0.30
3.00
0.00
0.00
8612

```
Note: Csv file is place in root directory and the output is calculated base on the following exchange rates: EUR:USD - 1:1.1497, EUR:JPY - 1:129.53

### Unit test

```php
➜  composer phpunit

PHPUnit 7.5.20

.......................                                           23 / 23 (100%)

Time: 21 ms, Memory: 4.00 MB

OK (23 tests, 23 assertions)

```
### Example Usage


```
➜  cat input.csv 

2014-12-31,4,private,withdraw,1200.00,EUR
2015-01-01,4,private,withdraw,1000.00,EUR
2016-01-05,4,private,withdraw,1000.00,EUR
2016-01-05,1,private,deposit,200.00,EUR
2016-01-06,2,business,withdraw,300.00,EUR
2016-01-06,1,private,withdraw,30000,JPY
2016-01-07,1,private,withdraw,1000.00,EUR
2016-01-07,1,private,withdraw,100.00,USD
2016-01-10,1,private,withdraw,100.00,EUR
2016-01-10,2,business,deposit,10000.00,EUR
2016-01-10,3,private,withdraw,1000.00,EUR
2016-02-15,1,private,withdraw,300.00,EUR
2016-02-19,5,private,withdraw,3000000,JPY
```


**Step 1:**
**Create currency collection from given currencies**

``` php
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
```

**Step 2:**
**Read CSV to create a associative array**

```php
$columns = ['date','userId','userType','operationType','amount','currencyShortCode'];
$csv = new CsvReader('./input.csv', $columns);
```

**Step 3:**
**Create transaction collection form array provided by csv**

```php
$transactionCollections = new TransactionCollections($csv->toArray());
```

**Step 4:**
**Calculate commissions with transaction collection and currency collection**

```php
$calculate = new CalculateCommissions($transactionCollections, $currencyCollections);
$calculate->generateCommission();
$calculate->getFeesInHorizontally();
```