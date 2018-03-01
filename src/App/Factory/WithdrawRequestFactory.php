<?php

namespace App\Factory;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Withdraw;

/**
 * Class WithdrawRequestFactory
 * @package App\Factory
 */
class WithdrawRequestFactory implements InterfaceRequestFactory
{
    /**
     * @param Request $request
     * @return Withdraw
     */
    public static function create(Request $request)
    {
        $data = $request->query->get('getMoneyAmount');

        $withdraw = new Withdraw();
        $withdraw->setValueWithdraw($data);

        return $withdraw;
    }
}
