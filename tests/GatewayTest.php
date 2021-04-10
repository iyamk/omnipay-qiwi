<?php

namespace Omnipay\Qiwi\Tests;

use Omnipay\Qiwi\Message\NotificationRequest;
use Omnipay\Qiwi\Message\PurchaseRequest;
use Omnipay\Qiwi\QiwiP2PGateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var QiwiP2PGateway */
    protected $gateway;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new QiwiP2PGateway($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testPurchase()
    {
        $request = $this->gateway->purchase([
            'amount' => '0.1',
            'currency' => 'USD',
            'transactionId' => 213,
            'description' => 'Purchase: 123',
        ]);

        $this->assertInstanceOf(PurchaseRequest::class, $request);
        $this->assertSame('0.10', $request->getAmount());
    }

    public function testAcceptNotification()
    {
        $request = $this->gateway->acceptNotification();

        $this->assertInstanceOf(NotificationRequest::class, $request);
    }

}
