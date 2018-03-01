<?php

use \App\Factory\WithdrawRequestFactory;
use \App\Service\CashMachineService;
use \App\Entity\Withdraw;

/**
 * Class CashMachineServiceTest
 */
class CashMachineServiceTest extends \PHPUnit_Framework_TestCase
{
    private $cashMachineService;
    private $withdraw;

    public function setUp()
    {
        $this->cashMachineService = new CashMachineService();
        $this->withdraw = new Withdraw();
    }

    public function testWithSuccess()
    {
        $withdraw = new Withdraw();
        $withdraw->setValueWithdraw(180);
        $res = $this->cashMachineService->cashOut($withdraw);
        $this->assertEquals([100, 50, 20, 10], $res);

        $withdraw->setValueWithdraw(30);
        $res = $this->cashMachineService->cashOut($withdraw);
        $this->assertEquals([20, 10], $res);

        $withdraw->setValueWithdraw(80);
        $res = $this->cashMachineService->cashOut($withdraw);
        $this->assertEquals([50, 20, 10], $res);


    }

    public function testParamNull()
    {
        $withdraw = new Withdraw();
        $withdraw->setValueWithdraw(NULL);
        $res = $this->cashMachineService->cashOut($withdraw);

        $this->assertEquals([], $res);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Unavailable notes for this request.
     */
    public function testValueInvalid()
    {
        $withdraw = new Withdraw();
        $withdraw->setValueWithdraw(125);
        $res = $this->cashMachineService->cashOut($withdraw);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Invalid value.
     */
    public function testNegativeValue()
    {
        $withdraw = new Withdraw();
        $withdraw->setValueWithdraw(-130);
        $this->cashMachineService->cashOut($withdraw);
    }   
}
