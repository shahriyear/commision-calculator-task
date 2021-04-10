<?php

declare(strict_types=1);

use Fahim\CommissionTask\Exception\NotNumericException;
use Fahim\CommissionTask\Service\Func;
use PHPUnit\Framework\TestCase;

/**
 * Helper functions
 */
class FuncTest extends TestCase
{
    /**
     * for get percentage
     *
     * @return void
     */
    public function testGetPercentage()
    {
        $amount=100;
        $percentage=3;
        $result = Func::getPercentage($amount, $percentage);
        $this->assertEquals(
            3,
            $result
        );
    }

    /**
     * for invalid amount exception
     *
     * @return void
     */
    public function testGetPercentageNotNumericException()
    {
        $this->expectException(NotNumericException::class);
        $amount="abc";
        $percentage=3;
        Func::getPercentage($amount, $percentage);
    }
    
    /**
     * get round and format with precision
     *
     * @return void
     */
    public function testRoundWithPrecision()
    {
        $amount=100.123456;
        $percentage=2;
        $result = Func::roundWithPrecision($amount, $percentage);
        $this->assertEquals(
            100.13,
            $result
        );
    }
}
