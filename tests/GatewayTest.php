<?php

namespace Omnipay\Qiwi\Tests;

use Omnipay\Qiwi\Message\NotificationRequest;
use Omnipay\Qiwi\Message\PurchaseRequest;
use Omnipay\Qiwi\P2PGateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var P2PGateway */
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new P2PGateway($this->getHttpClient(), $this->getHttpRequest());
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
