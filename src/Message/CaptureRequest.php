<?php

namespace Ampeco\OmnipayPayhub\Message;

class CaptureRequest extends AbstractRequest
{
    public function getEndpoint()
    {
        $this->validate('transactionReference');

        return "pga/transactions/{$this->getTransactionReference()}/complete_hold";
    }

    public function getData()
    {
        $this->validate('amount');

        return [
            "amount" => $this->getAmount() * 100,
        ];
    }
}
