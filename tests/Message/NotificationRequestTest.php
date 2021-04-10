<?php

namespace Omnipay\Qiwi\Tests\Message;

use Omnipay\Qiwi\Message\NotificationRequest;
use Omnipay\Tests\TestCase;

class NotificationRequestTest extends TestCase
{

    /**
     * @var NotificationRequest
     */
    private $request;

    protected function setUp()
    {
        parent::setUp();

        $mockResponse = $this->getMockHttpResponse('NotificationSuccess.txt');

        $data = json_decode($mockResponse->getBody()->getContents(), true);

        $mockHttpRequest = $this->getMockBuilder('\Symfony\Component\HttpFoundation\Request')->setConstructorArgs([
                    [],
                    // directly passing an array of the POSTed data would do but to prevent
                    // duplicate array in test, i made it seem like an API response then
                    // get the response as an array using json() method.
                    $data,
                ])->setMethods()->getMock();

        $this->request = new NotificationRequest($this->getHttpClient(), $mockHttpRequest);
    }

    public function testGetData()
    {
        $data = $this->request->getData();
        $this->assertEquals([
            'version'    => 1,
            'bill'       => [
                'siteId'             => '89a11b-00',
                'billId'             => '1f73402c644002a7ea3c9532e8ba4139',
                'amount'             => [
                    'value'    => '10.00',
                    'currency' => 'RUB',
                ],
                'status'             => [
                    'value'           => 'PAID',
                    'changedDateTime' => '2021-01-01T00:00:01+03',
                ],
                'customer'           => [],
                'customFields'       => [
                    'CHECKOUT_REFERER' => 'https://example.com',
                    'themeCode'        => 'Test-MNaIYqI4Di',
                ],
                'comment'            => null,
                'creationDateTime'   => '2021-01-01T00:00:01+03',
                'expirationDateTime' => '2021-01-01T00:00:01+03',
            ],
            'secret_key' => null,
            'hash'       => null,
        ], $data);
    }

    public function testSendData()
    {
        $data     = $this->request->getData();
        $response = $this->request->sendData($data);
        $this->assertSame('Omnipay\Qiwi\Message\NotificationResponse', get_class($response));
    }
}
