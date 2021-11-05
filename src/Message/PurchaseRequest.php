<?php

namespace Ampeco\OmnipayPayhub\Message;

class PurchaseRequest extends AbstractRequest
{
    public function setHold($value)
    {
        $this->setParameter('hold', (bool) $value);
    }

    public function getHold()
    {
        return $this->getParameter('hold');
    }

    public function getEndpoint()
    {
        return 'pga/transactions';
    }

    public function getData()
    {
        $this->validate('transactionId', 'amount', 'token', 'description', 'hold');

        return [
            "amount" => $this->getAmountInteger(),
            "external_id" => $this->getTransactionId(),
            "payer" => [
                "source" => "RECURRENT_TRANSACTION",
                "transaction_id" => $this->getToken(),
            ],
            "description" => $this->getDescription(),
            "short_description" => $this->getDescription(),
            "client_ip" => "127.0.0.1",
            "merchant_config_id" => $this->getMerchantConfigId(),
            "config_id" => $this->getConfigId(),
            "hold" => $this->getHold(),
        ];
    }

    protected function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
