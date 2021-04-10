<?php

namespace Omnipay\Qiwi\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\Qiwi\Traits\ResponseFieldsTrait;

class NotificationResponse extends AbstractResponse implements NotificationInterface
{
    use ResponseFieldsTrait;

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

    public function isSuccessful()
    {
        return $this->checkNotificationSignature() && $this->getTransactionStatus() === self::STATUS_COMPLETED;
    }

    public function getMessage()
    {
        return $this->checkNotificationSignature() ?
            sprintf('Callback hash does not match expected value') : $this->getStatus();
    }

    /**
     * Checks notification data signature.
     * @return bool Signature is valid or not.
     */
    public function checkNotificationSignature()
    {
        $processedNotificationData = [
            'billId'          => (string) $this->getTransactionId(),
            'amount.value'    => $this->getAmount(),
            'amount.currency' => (string) $this->getCurrency(),
            'siteId'          => (string) $this->getSiteId(),
            'status'          => (string) $this->getStatus(),
        ];
        ksort($processedNotificationData);
        $processedNotificationDataKeys = join('|', $processedNotificationData);
        $hash                          = hash_hmac(
            'sha256',
            $processedNotificationDataKeys,
            $this->getSecretKey(),
        );

        return $hash === $this->getHash();
    }
}
