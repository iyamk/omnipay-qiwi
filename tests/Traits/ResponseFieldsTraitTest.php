<?php

namespace Omnipay\Qiwi\Tests\Traits;

use Omnipay\Qiwi\Traits\ResponseFieldsTrait;
use PHPUnit\Framework\TestCase;

class ResponseFieldsTraitTest extends TestCase
{

    use ResponseFieldsTrait;

    /**
     * @var array
     */
    private $testData;

    protected function setUp()
    {
        $this->testData = [];
    }

    public function getData()
    {
        return $this->testData;
    }

    public function testGet()
    {
        $this->testData = [
            'version' => '1',
            'bill'    => [
                'siteId'   => 'abcd-00',
                'billId'   => '1',
                'amount'   => [
                    'value'    => '10.00',
                    'currency' => 'RUB',
                ],
                'customer' => [],
            ],
        ];

        $this->assertEquals('1', $this->get('version'));
        $this->assertEquals('1', $this->get('bill.billId'));
        $this->assertEquals('abcd-00', $this->get('bill.siteId'));
        $this->assertEquals('10.00', $this->get('bill.amount.value'));
        $this->assertEquals('RUB', $this->get('bill.amount.currency'));
        $this->assertEquals('default-value', $this->get('bill.customer.phone', 'default-value'));
    }


}
