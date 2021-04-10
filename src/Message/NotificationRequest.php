<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Http\Client;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class NotificationRequest extends AbstractRequest
{

    private $data;

    public function __construct(Client $httpClient, HttpRequest $httpRequest)
    {
        parent::__construct($httpClient, $httpRequest);

        $this->data = $this->httpRequest->request->all();
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getData()
    {
        return array_merge($this->data, [
            'secret_key' => $this->getSecretKey(),
            'hash' => $this->httpRequest->headers->get('X-Api-Signature-SHA256'),
        ]);
    }

    /**
     * {@inheritdoc}
     *
     * @param  mixed  $data
     *
     * @return NotificationResponse
     */
    public function sendData($data)
    {
        return $this->response = new NotificationResponse($this, $data);
    }

}
