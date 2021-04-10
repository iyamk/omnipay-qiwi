<?php

namespace Omnipay\Qiwi;

use Omnipay\Common\AbstractGateway;
use Omnipay\Qiwi\Message\NotificationRequest;
use Omnipay\Qiwi\Message\PurchaseRequest;

/**
 * @method \Omnipay\Common\Message\RequestInterface completeAuthorize(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface capture(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface completePurchase(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface refund(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface void(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface createCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface updateCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface deleteCard(array $options = [])
 * @method \Omnipay\Common\Message\RequestInterface authorize(array $options = [])
 */
class QiwiP2PGateway extends AbstractGateway
{
    public function getName()
    {
        return 'Qiwi P2P';
    }

    public function getDefaultParameters()
    {
        return [
            'public_key'    => '',
            'secret_key'    => '',
            'success_url'   => null,
            'custom_fields' => null,
        ];
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

    /**
     * @param array $parameters
     *
     * @return \Omnipay\Common\Message\AbstractRequest
     */
    public function purchase(array $parameters = [])
    {
        return $this->createRequest(PurchaseRequest::class, $parameters);
    }

    /**
     * Handle notification callback.
     * Replaces completeAuthorize() and completePurchase()
     *
     * @return \Omnipay\Common\Message\AbstractRequest|NotificationRequest
     */
    public function acceptNotification(array $parameters = [])
    {
        return $this->createRequest(NotificationRequest::class, $parameters);
    }

}
