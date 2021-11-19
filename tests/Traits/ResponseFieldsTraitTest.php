<?php

namespace Omnipay\Qiwi\Tests\Traits;

use PHPUnit\Framework\TestCase;

class ResponseFieldsTraitTest extends TestCase
{

    /**
     * @var array
     */
    private $testData;

    protected function setUp(): void
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


    private function get($key, $default = null)
    {
        $array = $this->getData();

        if (!is_array($array)) {
            return $default;
        }

        if (is_null($key)) {
            return $array;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        if (strpos($key, '.') === false) {
            return $array[$key] ?? $default;
        }

        foreach (explode('.', $key) as $segment) {
            if (is_array($array) && array_key_exists($segment, $array)) {
                $array = $array[$segment];
            } else {
                return $default;
            }
        }

        return $array;
    }
}
