<?php

declare(strict_types=1);

namespace Fahim\CommissionTask\Commission;

use Fahim\CommissionTask\Commission\CommissionTypes\CommissionForBusinessWithdraw;
use Fahim\CommissionTask\Commission\CommissionTypes\CommissionForDeposit;
use Fahim\CommissionTask\Commission\CommissionTypes\CommissionForPrivateWithDraw;
use Fahim\CommissionTask\Entity\Transaction;
use Fahim\CommissionTask\Service\CurrencyCollections;
use Fahim\CommissionTask\Service\TransactionCollections;

/**
 * Commission abstract for class mapper
 */
abstract class CommissionAbstract
{
    /**
    * @var Transaction
    */
    protected $transaction;

    /**
     * @var CurrencyCollections
     */
    protected $currencyCollections;

    /**
     * @var TransactionCollections
     */
    protected $transactionCollections;

     
    /**
     * Map every type of commission by using user type and operation type
     *
     * @var array
     */
    protected $classMapper = [
        'private_deposit' => CommissionForDeposit::class,
        'business_deposit' => CommissionForDeposit::class,
        'business_withdraw' => CommissionForBusinessWithdraw::class,
        'private_withdraw' => CommissionForPrivateWithDraw::class,
    ];

    /**
     * @param Transaction $transaction
     * @param CurrencyCollections $currencyCollections
     * @param TransactionCollections $transactionCollections
     */
    public function __construct(
        Transaction $transaction,
        CurrencyCollections $currencyCollections,
        TransactionCollections $transactionCollections
    ) {
        $this->transaction = $transaction;
        $this->currencyCollections = $currencyCollections;
        $this->transactionCollections = $transactionCollections;
    }

    /**
     * Get the commission class instance for transaction
     *
     * @return CommissionInterface
     */
    protected function getInstanceByUserAndOperationType():CommissionInterface
    {
        $classKey = $this->makeClassMapperKey();
        
        if (
            !array_key_exists($classKey, $this->classMapper)
            || !class_exists($this->classMapper[$classKey])
        ) {
            throw new \Exception("{$classKey} class not mapped");
        }
        
        $class = $this->classMapper[$classKey];
        $instance = new $class(
            $this->transaction,
            $this->currencyCollections,
            $this->transactionCollections
        );

        if ($instance instanceof CommissionInterface === false) {
            throw new \Exception("{$this->classMapper[$classKey]} is not an instance of " . CommissionInterface::class);
        }

        return $instance;
    }

    /**
     * Make class mapper key
     *
     * @return string
     */
    private function makeClassMapperKey():string
    {
        return strtolower($this->transaction->getUserType().'_'.$this->transaction->getOperationType());
    }
}
