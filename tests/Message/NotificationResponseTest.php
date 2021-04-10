<?php

namespace Omnipay\Qiwi\Tests\Message;

use Omnipay\Qiwi\Message\NotificationResponse;
use Omnipay\Tests\TestCase;

class NotificationResponseTest extends TestCase
{

    public function testResponseFail()
    {
        $mockResponse = $this->getMockHttpResponse('NotificationFail.txt');

        $data = json_decode($mockResponse->getBody()->getContents(), true);

        $data['secret_key'] = 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6ImQ4MmZiMi0wMCIsInVzZXJfaWQiOiIzODA5MTk2ODEyMTAiLCJzZWNyZXQiOiIwNzQwYTMzZTIxNGE1NjIzOTgyYTFhYWQ4NDIwMzcyNzBjMzAwMjQzOGQ5YzBmOTc5MmY5ZTUzYjRlMGQxMzAyIn19';
        $data['hash'] = 'fail-signature';

        $response = new NotificationResponse($this->getMockRequest(), $data);

        $this->assertFalse($response->checkNotificationSignature());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame(null, $response->getTransactionReference());
        $this->assertSame('1f73402c644002a7ea3c9532e8ba4139', $response->getTransactionId());
        $this->assertSame('PAID', $response->getStatus());
        $this->assertSame('completed', $response->getTransactionStatus());
        $this->assertSame($data, $response->getData());
    }

    public function testResponsePass()
    {
        $mockResponse = $this->getMockHttpResponse('NotificationSuccess.txt');

        $data = json_decode($mockResponse->getBody()->getContents(), true);

        $data['secret_key'] = 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6ImQ4MmZiMi0wMCIsInVzZXJfaWQiOiIzODA5MTk2ODEyMTAiLCJzZWNyZXQiOiIwNzQwYTMzZTIxNGE1NjIzOTgyYTFhYWQ4NDIwMzcyNzBjMzAwMjQzOGQ5YzBmOTc5MmY5ZTUzYjRlMGQxMzAyIn19';
        $data['hash'] = 'e7fc6a163961de6c863737f72e2ff109f38c06fd4fda06d2211044c3adf0969a';

        $response = new NotificationResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->checkNotificationSignature());
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('PAID', $response->getStatus());
    }

    public function testResponseWaiting()
    {
        $mockResponse = $this->getMockHttpResponse('NotificationWaiting.txt');

        $data = json_decode($mockResponse->getBody()->getContents(), true);

        $data['secret_key'] = 'eyJ2ZXJzaW9uIjoiUDJQIiwiZGF0YSI6eyJwYXlpbl9tZXJjaGFudF9zaXRlX3VpZCI6ImQ4MmZiMi0wMCIsInVzZXJfaWQiOiIzODA5MTk2ODEyMTAiLCJzZWNyZXQiOiIwNzQwYTMzZTIxNGE1NjIzOTgyYTFhYWQ4NDIwMzcyNzBjMzAwMjQzOGQ5YzBmOTc5MmY5ZTUzYjRlMGQxMzAyIn19';
        $data['hash'] = '6a61ec958880259f6317b252809d8570b68f4cc2dac881590f00684d1aa968f8';

        $response = new NotificationResponse($this->getMockRequest(), $data);

        $this->assertTrue($response->checkNotificationSignature());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('WAITING', $response->getStatus());
    }
}
