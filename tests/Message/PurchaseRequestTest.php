<?php

namespace Omnipay\Qiwi\Tests\Message;

use Omnipay\Qiwi\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{

    /**
     * @var PurchaseRequest
     */
    private $request;

    protected function setUp()
    {
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->setReturnUrl('https://example.com');
        $this->request->setPublicKey('c389f0f28ae2d2055b0749d13edf426c');

        $this->request->setDescription('description');
        $this->request->setAmount('10');
        $this->request->setCurrency('RUB');
        $this->request->setTransactionId(1);
        $this->request->setCustomFields([
            'themeCode' => 'abc',
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $expectedData = [
            'publicKey'    => 'c389f0f28ae2d2055b0749d13edf426c',
            'billId'       => 1,
            'amount'       => '10.00',
            'comment'      => 'description',
            'customFields' => [
                'themeCode' => 'abc',
            ],
        ];

        $this->assertEquals($expectedData, $data);
    }

    public function testSendSuccess()
    {
        $response = $this->request->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertTrue($response->isRedirect());
        $this->assertEquals('https://oplata.qiwi.com/create', $response->getRedirectUrl());
        $this->assertEquals('GET', $response->getRedirectMethod());
    }
}
