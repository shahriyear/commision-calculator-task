<?php

declare(strict_types=1);

use Fahim\CommissionTask\Exception\ColumnsNotFoundException;
use Fahim\CommissionTask\Exception\FileNotFoundException;
use Fahim\CommissionTask\Exception\NoDataFoundException;
use Fahim\CommissionTask\Service\CsvReader;
use PHPUnit\Framework\TestCase;

/**
 * Csv to array converting with column name
 */
class CsvReaderTest extends TestCase
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * Set columns
     *
     * @return void
     */
    public function setUp()
    {
        $this->columns = ['date','userId','userType','operationType','amount','currencyShortCode'];
    }

    /**
     * Get array from csv file
     *
     * @return void
     */
    public function testToArray()
    {
        $csvReader = new CsvReader('./input.csv', $this->columns);
        $result = $csvReader->toArray();
        $this->assertEquals(
            [
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
            ],
            $result
        );
    }

    /**
     * File not found exception
     *
     * @return void
     */
    public function testFileNotFoundException()
    {
        $this->expectException(FileNotFoundException::class);
        new CsvReader(null, $this->columns);
    }

    /**
     * Column not found exception
     *
     * @return void
     */
    public function testColumnNotFoundException()
    {
        $this->expectException(ColumnsNotFoundException::class);
        new CsvReader('./input.csv', []);
    }

    /**
     *  No data found exception
     *
     * @return void
     */
    public function testToArrayException()
    {
        $csvReader = new CsvReader('./empty.csv', $this->columns);
        $this->expectException(NoDataFoundException::class);
        $csvReader->toArray();
    }
}
