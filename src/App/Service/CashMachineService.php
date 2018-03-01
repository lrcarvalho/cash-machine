<?php

namespace App\Service;

use App\Entity\Withdraw;
use App\Exception\NoteUnavailableException;

/**
 * Class CashMachine
 * @package App\Service
 */
class CashMachineService
{
    const moneyNotes = [100, 50, 20, 10];

    /**
     * @param Withdraw $withdraw
     * @return array
     * @throws \Exception
     */
    public function cashOut(Withdraw $withdraw)
    {
        $value = $withdraw->getValueWithdraw();
        $this->isValidValue($value);
        $withdrawnMoney = $this->getMoney($value);

        return $withdrawnMoney;
    }

    /**
     * @param $value
     * @throws NoteUnavailableException
     * @throws \InvalidArgumentException
     */
    public function isValidValue($value)
    {
        $possibleValue = ($value % 10 == 0);
        $lessThanZeroValue = $value < (int)0 ? true :false;
        $isNumericValue = is_numeric($value);
        $isNullValue = is_null($value);

        if((!$isNumericValue && !$isNullValue) || $lessThanZeroValue) {
            throw new \InvalidArgumentException("Invalid value.");
        }

        if(!$possibleValue) {
            throw new NoteUnavailableException("Unavailable notes for this request.");
        }
    }

    /**
     * @param $value
     * @return array
     */
    public function getMoney($value)
    {
        $withdrawnMoney = array();

        foreach (self::moneyNotes as $money)
        {
            while($money <= $value)
            {
                array_push($withdrawnMoney, number_format($money, 2, '.',''));
                $value -= $money;
            }
        }

        return $withdrawnMoney;
    }
}
