<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\NotificationInterface;

class NotificationRequest extends AbstractRequest implements NotificationInterface
{
    public const HASH_ERROR = 'hash_error';

    protected $data;

    public function getData()
    {
        if (isset($this->data)) {
            return $this->data;
        }

        return $this->data = $this->httpRequest->request->all();
    }

    public function getTransactionId()
    {
        return $this->getBillId();
    }

    public function getTransactionReference()
    {
        return $this->getBillId();
    }

    public function getTransactionStatus()
    {
        switch ($this->getStatus()) {
            case 'PAID':
                return self::STATUS_COMPLETED;
            case 'WAITING':
                return self::STATUS_PENDING;
            default:
                return self::STATUS_FAILED;
        }
    }

    public function getMessage()
    {
        if (!$this->isValid()) {
            return self::HASH_ERROR;
        }

        return null;
    }

    public function isValid()
    {
        return $this->getSignature() === $this->buildSignature();
    }

    public function getSignature()
    {
        return $this->httpRequest->headers->get('X-Api-Signature-SHA256');
    }

    public function buildSignature()
    {
        $processedNotificationData = [
            'billId'          => (string) $this->getBillId(),
            'amount.value'    => $this->getAmount(),
            'amount.currency' => (string) $this->getCurrency(),
            'siteId'          => (string) $this->getSiteId(),
            'status'          => (string) $this->getStatus(),
        ];

        ksort($processedNotificationData);

        $processedNotificationDataKeys = join('|', $processedNotificationData);

        return hash_hmac('sha256', $processedNotificationDataKeys, $this->getParameter('secret_key'));
    }

    public function getSiteId()
    {
        return $this->get('bill.siteId');
    }

    public function getBillId()
    {
        return $this->get('bill.billId');
    }

    public function getAmount()
    {
        return $this->normalizeAmount($this->get('bill.amount.value', 0.0));
    }

    public function getCurrency()
    {
        return $this->get('bill.amount.currency', 'RUB');
    }

    public function getStatus()
    {
        return $this->get('bill.status.value');
    }

    public function getChangedDateTime()
    {
        return $this->get('bill.status.changedDateTime');
    }

    public function getCustomerPhone()
    {
        return $this->get('bill.customer.phone');
    }

    public function getCustomerEmail()
    {
        return $this->get('bill.customer.email');
    }

    public function getCustomerAccount()
    {
        return $this->get('bill.customer.account');
    }

    public function getCustomerCustomFields()
    {
        return $this->get('bill.customFields');
    }

    public function getComment()
    {
        return $this->get('bill.comment');
    }

    public function getCreationDateTime()
    {
        return $this->get('bill.creationDateTime');
    }

    public function getExpirationDateTime()
    {
        return $this->get('bill.expirationDateTime');
    }

    public function getVersion()
    {
        return $this->get('version');
    }

    public function getSecretKey()
    {
        return $this->get('secret_key');
    }

    public function getHash()
    {
        return $this->get('hash');
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

    private function normalizeAmount($amount = 0): string
    {
        return number_format(round(floatval($amount), 2, PHP_ROUND_HALF_DOWN), 2, '.', '');
    }

    public function sendData($data)
    {
        return $this;
    }
}
