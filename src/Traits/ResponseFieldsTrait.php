<?php

namespace Omnipay\Qiwi\Traits;

trait ResponseFieldsTrait
{

    public function getTransactionId()
    {
        return $this->get('bill.billId');
    }

    public function getTransactionReference()
    {
        return null;
    }

    public function getSiteId()
    {
        return $this->get('bill.siteId');
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

    /**
     * Normalize amount.
     *
     * @param string|float|int $amount The value.
     *
     * @return string The API value.
     */
    private function normalizeAmount($amount = 0)
    {
        return number_format(round(floatval($amount), 2, PHP_ROUND_HALF_DOWN), 2, '.', '');
    }
}
