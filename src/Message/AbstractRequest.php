<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayRequest;

abstract class AbstractRequest extends OmnipayRequest
{
    protected $endpoint = 'https://oplata.qiwi.com/create';

    public function getEndpoint()
    {
        return $this->endpoint;
    }

    public function getPublicKey()
    {
        return $this->getParameter('public_key');
    }

    public function setPublicKey($value)
    {
        return $this->setParameter('public_key', $value);
    }

    public function getSecretKey()
    {
        return $this->getParameter('secret_key');
    }

    public function setSecretKey($value)
    {
        return $this->setParameter('secret_key', $value);
    }

    public function getSuccessUrl()
    {
        return $this->getParameter('success_url');
    }

    public function setSuccessUrl($value)
    {
        return $this->setParameter('success_url', $value);
    }

    public function getCustomFields()
    {
        return $this->getParameter('custom_fields');
    }

    public function setCustomFields($value)
    {
        return $this->setParameter('custom_fields', $value);
    }

}
