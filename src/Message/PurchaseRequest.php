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

        $params = [
            "amount" => $this->getAmountInteger(),
            "external_id" => $this->getTransactionId(),
            "description" => $this->getDescription(),
            "short_description" => $this->getDescription(),
            "client_ip" => "127.0.0.1",
            "hold" => $this->getHold(),
        ];

        if ($this->is2DS()) {
            $params["merchant_config_id"] = $this->getTransactionMerchantConfigId();
            $params["payer"] = [
                "source" => "WALLET",
                "value" => $this->getToken(),
                "client_id" => $this->getUserId(),
            ];
        } else {
            $params["config_id"] = $this->getConfigId();
            $params["merchant_config_id"] = $this->getMerchantConfigId();
            $params["payer"] = [
                "source" => "RECURRENT_TRANSACTION",
                "transaction_id" => $this->getToken(),
            ];
        }

        return $params;
    }

    protected function getResponseClass()
    {
        return PurchaseResponse::class;
    }
}
