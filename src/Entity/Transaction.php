<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Entity;

/**
 *Get transaction array and convert it to objects
 */
class Transaction
{
    /**
     * @var int
     */
    protected $transactionId;
    
    /**
     * @var \DateTime
     */
    protected $date;
    
    /**
     * @var int
     */
    protected $userId;
    
    /**
     * @var string
     */
    protected $userType;
    
    /**
     * @var string
     */
    protected $operationType;
    
    /**
     * @var Amount
     */
    protected $amount;
    
    /**
     * @param int $transactionId
     * @param \DateTime $date
     * @param int $userId
     * @param string $userType
     * @param string $operationType
     * @param int|float $amount
     * @param string $currencyShortCode
     */
    public function __construct(
        int $transactionId,
        \DateTime $date,
        int $userId,
        string $userType,
        string $operationType,
        $amount,
        string $currencyShortCode
    ) {
        $this->transactionId = $transactionId;
        $this->date = $date;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->operationType = $operationType;
        $this->amount = $amount;
        $this->currencyShortCode = $currencyShortCode;
    }
    
    /**
     *@return int
     */
    public function getTransactionId():int
    {
        return $this->transactionId;
    }
    
    /**
     * @return int
     */
    public function getUserId():int
    {
        return $this->userId;
    }
    
    /**
     * @return string
     */
    public function getOperationType():string
    {
        return $this->operationType;
    }
    
    /**
     * @return string
     */
    public function getUserType():string
    {
        return $this->userType;
    }
    
    /**
     * @return \DateTime
     */
    public function getDate():\DateTime
    {
        return $this->date;
    }
    
    /**
     * @return int|float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrencyShortCode():string
    {
        return $this->currencyShortCode;
    }
}
