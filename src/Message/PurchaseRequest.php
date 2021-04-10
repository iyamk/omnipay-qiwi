<?php

namespace Omnipay\Qiwi\Message;

class PurchaseRequest extends AbstractRequest
{

    public function getData()
    {
        $this->validate('amount', 'description', 'transactionId');

        $data = [
            'publicKey' => $this->getPublicKey(),
            'billId'    => $this->getTransactionId(),
            'amount'    => $this->getAmount(),
            'comment'   => $this->getDescription(),
        ];

        if ($this->getSuccessUrl()) {
            $data['successUrl'] = $this->getSuccessUrl();
        }

        if ($this->getCustomFields()) {
            $data['customFields'] = $this->getCustomFields();
        }

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data);
    }

}
